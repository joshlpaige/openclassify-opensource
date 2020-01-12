<?php namespace Visiosoft\AdvsModule\Adv;

use Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface;
use Anomaly\Streams\Platform\Model\Advs\AdvsAdvsEntryModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Visiosoft\AdvsModule\Adv\Contract\AdvRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;
use Visiosoft\CatsModule\Category\CategoryModel;
use Visiosoft\AdvsModule\Category\Contract\CategoryRepositoryInterface;
use Visiosoft\DopingsModule\Doping\DopingModel;
use Visiosoft\LocationModule\City\CityModel;
use Visiosoft\LocationModule\Country\CountryModel;

class AdvRepository extends EntryRepository implements AdvRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var AdvModel
     */
    protected $model;

    /**
     * Create a new AdvRepository instance.
     *
     * @param AdvModel $model
     */
    public function __construct(
        AdvModel $model,
        SettingRepositoryInterface $settings
    )
    {
        $this->model = $model;
        $this->settings = $settings;
    }

    /**
     * Resolve the advs.
     *
     * @return AdvsInterface|null
     */
    public function findById($id)
    {
        return $this->model->orderBy('created_at', 'DESC')->where('advs_advs.id', $id)->first();
    }

    public function searchAdvs($type, $param = null, $customParameters = null, $limit = null)
    {
        $isActiveDopings = new AdvModel();
        $isActiveDopings = $isActiveDopings->is_enabled('dopings');

        $query = $this->model;
        $query = $query->where('advs_advs.slug', '!=', "");
        $query = $query->where('advs_advs.status', 'approved');
        $query = $query->where('advs_advs.finish_at', '>', date('Y-m-d H:i:s'));


        $query = $query->leftJoin('advs_advs_translations', function ($join) {
            $join->on('advs_advs.id', '=', 'advs_advs_translations.entry_id');
            $join->where('advs_advs_translations.locale', '=', Request()->session()->get('_locale'));
        });

        if (!empty($param['keyword'])) {
            $delimiter = '_';
            $keyword = str_slug($param['keyword'], $delimiter);
            $query = $query->where(function ($query) use ($keyword) {
                $query->where('advs_advs_translations.advs_desc', 'like', '%' . $keyword . '%')
                    ->orWhere('slug', 'like', '%' . $keyword . '%')
                    ->orWhere('advs_advs_translations.name', 'like', '%' . $keyword . '%');
            });
        }
        if (!empty($param['country'])) {
            $query = $query->where('country_id', $param['country']);
        }
        if (isset($param['city']) and !empty(array_filter($param['city']))) {
            $query = $query->whereIn('city', $param['city']);
        }
        if (!empty($param['cat'])) {
            $cat = new CategoryModel();
            $cat_d = $cat->find($param['cat']);
            if ($cat_d->parent_category_id == null)
                $catLevel = 1;
            else
                $catLevel = $cat->getCatLevel($param['cat']);
            $catLevel = "cat" . $catLevel;
            $query = $query->where($catLevel, $param['cat']);
        }
        if (!empty($param['user'])) {
            $query = $query->where('advs_advs.created_by_id', $param['user']);
        }
        if (isset($param['district']) and !empty(array_filter($param['district']))) {
            $query = $query->whereIn('district', $param['district']);
        }
        if (isset($param['neighborhood']) and !empty(array_filter($param['neighborhood']))) {
            $query = $query->whereIn('neighborhood', $param['neighborhood']);
        }
        if (isset($param['village']) and !empty(array_filter($param['village']))) {
            $query = $query->whereIn('village', $param['village']);
        }
        if (!empty($param['min_price'])) {
            $num = $param['min_price'];
            $int = (int)$num;
            $column = "JSON_EXTRACT(foreign_currencies, '$." . $param['currency'] . "') >=" . $int;
            $query = $query->whereRaw($column);
        }
        if (!empty($param['max_price'])) {
            $num = $param['max_price'];
            $int = (int)$num;
            $column = "JSON_EXTRACT(foreign_currencies, '$." . $param['currency'] . "') <=" . $int;
            $query = $query->whereRaw($column);
        }
        if (!empty($param['date'])) {
            if ($param['date'] === 'day') {
                $query = $query->where('advs_advs.publish_at', '>=', Carbon::now()->subDay());
            } elseif ($param['date'] === 'week') {
                $query = $query->where('advs_advs.publish_at', '>=', Carbon::now()->subWeek());
            } elseif ($param['date'] === 'month') {
                $query = $query->where('advs_advs.publish_at', '>=', Carbon::now()->subMonth());
            }
        }
        if (!empty($param['photo'])) {
            $query = $query->whereNotNull('cover_photo');
        }
        if (!empty($param['video'])) {
            $query = $query->where('cover_photo', 'like', '%video/upload/w_400,e_loop%');
        }
        if (!empty($param['map']) && $param['map'] == true) {
            $query = $query->whereNotNull('map_Val');
        }

        foreach ($param as $para => $value) {
            if (substr($para, 0, 3) === "cf_") {
                $id = substr($para, 3);
                $customParameters[] = ['id' => "$.cf" . $id, 'value' => $param[$para]];
            }
        }

        foreach ($customParameters as $key => $customParameter) {
            if ($key == 0) {
                $jsonQuery = "(";
            }
            $cfId = $customParameter['id'];
            $cfValue = $customParameter['value'];
            $cf = "'" . $cfId . "'";
            $valueCount = count($cfValue);

            if ($cfValue) {
                foreach ($cfValue as $key1 => $value) {
                    if ($key1 == 0 and $cfValue > 1) {
                        $jsonQuery = $jsonQuery . "(";
                    }
                    $jsonQuery = $jsonQuery . 'JSON_CONTAINS(cf_json, \'"' . $value . '"\', ' . $cf . ')';
                    if ($key1 == $valueCount - 1 and $cfValue > 1) {
                        $jsonQuery = $jsonQuery . ")";
                    }
                    if ($key1 < $valueCount - 1) {
                        $jsonQuery = $jsonQuery . " or ";
                    } elseif ($key1 == $valueCount - 1 and $key != count($customParameters) - 1) {
                        $jsonQuery = $jsonQuery . " and ";
                    }
                }
            }
            if ($key == count($customParameters) - 1) {
                $jsonQuery = $jsonQuery . ")";
            }
        }
        if (isset($jsonQuery)) {
            $query = $query->whereRaw($jsonQuery);
        }

        if (!empty($param['max_price'])) {
            $num = $param['max_price'];
            $int = (int)$num;
            $column = "JSON_EXTRACT(foreign_currencies, '$." . $param['currency'] . "') <=" . $int;
            $query = $query->whereRaw($column);
        }

        if (!empty($param['max_price'])) {
            $num = $param['max_price'];
            $int = (int)$num;
            $column = "JSON_EXTRACT(foreign_currencies, '$." . $param['currency'] . "') <=" . $int;
            $query = $query->whereRaw($column);
        }

        foreach ($param as $para => $value) {
            if (substr($para, 4, 3) === "cf_") {
                $id = substr($para, 7);
                $minmax = substr($para, 0, 3);
                if ($minmax == 'min') {

                    $num = $param[$minmax . '_cf_' . $id];
                    $int = (int)$num;
                    $column = "JSON_EXTRACT(cf_json, '$.cf" . $id . "') >= '" . $int . "'";
                    $query = $query->whereRaw($column);

                }
                if ($minmax == 'max') {

                    $num = $param[$minmax . '_cf_' . $id];
                    $int = (int)$num;
                    $column = "JSON_EXTRACT(cf_json, '$.cf" . $id . "') <= '" . $int . "'";
                    $query = $query->whereRaw($column);

                }
            }
        }

        if (!empty($param['dlong']) && !empty($param['dlat']) && !empty($param['distance'])) {
            $query = $query->whereNotNull('coor');
            $query = $query->whereRaw("ST_DISTANCE(ST_GeomFromText('POINT(" . $param['dlong'] . " " . $param['dlat'] . ")'), coor) < " . $param['distance']);
        }

        if ($isActiveDopings) {
            if ($param == null) {
                $DopingModel = new DopingModel();
                $doping_advs_ids = $DopingModel->getFeaturedAds(3);
                $query = $query->whereIn('advs_advs.id', $doping_advs_ids);
            }
            $query = $query->leftJoin('dopings_dopings', function ($join) {
                $join->on('advs_advs.id', '=', 'dopings_dopings.adv_name_id');
                $join->where('dopings_dopings.doping_type_id', '=', 4);
            });

            $query = $query->select('advs_advs.*', 'dopings_dopings.id as doping');
        }
        if (!empty($param['sort_by'])) {
            switch ($param['sort_by']) {
                case "sort_price_up":
                    $query = $query->orderBy('price', 'desc');
                    break;
                case "sort_price_down":
                    $query = $query->orderBy('price', 'asc');
                    break;
                case "sort_time":
                    $query = $query->orderBy('advs_advs.created_at', 'desc');
                    break;
            }
        } else {
            $query = $query->orderBy('advs_advs.created_at', 'desc');
            $query = $query->select('advs_advs.*', 'advs_advs_translations.name as name', 'advs_advs_translations.advs_desc as advs_desc');
        }

        if ($type == "list") {
            return $query->paginate($this->settings->value('streams::per_page'));
        } else {
            return $query->get();
        }
    }

    public function softDeleteAdv($id)
    {
        return $this->find($id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
    }

    public function getLocationNames($adv)
    {
        $country = CountryModel::query()->where('location_countries.id', $adv->country_id)->first();
        $city = CityModel::query()->where('location_cities.id', $adv->city)->first();
        if ($country != null) {
            $adv->setAttribute('country_name', $country->name);
        }
        if ($city != null) {
            $adv->setAttribute('city_name', $city->name);
        }
        return $adv;
    }

    public function getCatNames($adv)
    {
        $cat1 = CategoryModel::query()->where('cats_category.id', $adv->cat1)->first();
        $cat2 = CategoryModel::query()->where('cats_category.id', $adv->cat2)->first();

        if (!is_null($cat1))
            $adv->setAttribute('cat1_name', $cat1->name);
        else
            $adv->setAttribute('cat1_name', "");

        if (!is_null($cat2))
            $adv->setAttribute('cat2_name', $cat2->name);

        else
            $adv->setAttribute('cat2_name', "");


        return $adv;
    }

    public function getListItemAdv($id)
    {
        $adv = $this->model
            ->where('advs_advs.id', $id)
            ->leftJoin('users_users as u1', 'advs_advs.created_by_id', '=', 'u1.id')
            ->select('advs_advs.*','u1.first_name as first_name', 'u1.last_name as last_name', 'u1.id as owner_id')
            ->inRandomOrder()
            ->first();

        $adv = $this->getLocationNames($adv);

        return $adv;
    }

    public function addAttributes($advs)
    {
        foreach ($advs as $adv) {
            $adv = $this->getLocationNames($adv);
            $adv = $this->getCatNames($adv);
        }

        return $advs;
    }

    public function cover_image_update($adv)
    {
        if (count($adv->files) != 0) {
            $file_url = 'files/images/' . $adv->files[0]->name;
            $adv->update(['cover_photo' => $file_url]);
        }
    }

    public function delete_empty_advs()
    {
        AdvsAdvsEntryModel::query()->where('slug', "")->forceDelete();
        DB::table('advs_advs_translations')->where('name', NULL)->delete();
    }

    public function getRecommendedAds($id)
    {
        return AdvModel::query()
            ->where('advs_advs.id', '!=', $id)
            ->where('advs_advs.status', 'approved')
            ->select('advs_advs.*')
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();
    }

    public function getLastAd($id)
    {
        return AdvsAdvsEntryModel::query()->where('advs_advs.created_by_id', '=', $id)->max('id');
    }

    public function getAdvArray($id)
    {
        return AdvsAdvsEntryModel::query()->where('advs_advs.id', $id)->first()->toArray();
    }

    public function getQuantity($quantity, $type, $item)
    {
        if ($type == "minus") {
            return $quantity - 1;
        } elseif ($type == "plus") {
            return $quantity + 1;
        } else {
            return $quantity;
        }
    }

    public function findByIds($ids)
    {
        return $this->model->orderBy('created_at', 'DESC')->whereIn('advs_advs.id', $ids)->get();
    }


    /**
     * Get Latest Ads
     * @return mixed
     */
    public function latestAds()
    {
        $latest_advs = $this->model
            ->whereDate('finish_at', '>=', date("Y-m-d H:i:s"))
            ->where('status', '=', 'approved')
            ->where('slug', '!=', '')
            ->orderBy('publish_at', 'desc')
            ->limit(setting_value('visiosoft.module.advs::latest-limit'))->get();

        $ads = $this->model->getLocationNames($latest_advs);

        foreach ($ads as $index => $ad) {
            $ads[$index]->detail_url = $this->model->getAdvDetailLinkByModel($ad, 'list');
            $ads[$index] = $this->model->AddAdsDefaultCoverImage($ad);
        }

        return $ads;
    }


}
