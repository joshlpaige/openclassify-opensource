<?php namespace Visiosoft\AdvsModule\Adv;

use Anomaly\Streams\Platform\Entry\EntryPresenter;
use Anomaly\Streams\Platform\Model\Cloudinary\CloudinaryVideoEntryModel;
use Anomaly\Streams\Platform\Model\Users\UsersUsersEntryModel;
use Illuminate\Routing\Route;

class AdvPresenter extends EntryPresenter
{


    public function getViewPhotoUrl()
    {
        $item_Photo = array();
        foreach ($this->files as $image) {
            $item_Photo[] = url('files/' . $image->path);
        }
        return $item_Photo;

    }

    public function getMediumPhotoUrl($fullPhotoUrl)
    {
        $mediumPhotoUrl = pathinfo($fullPhotoUrl);
        return $mediumPhotoUrl['dirname'] . '/md-' . $mediumPhotoUrl['basename'];
    }

    public function isAdVideo()
    {
        $isActive = new AdvModel();
        $isActiveCloudinary = $isActive->is_enabled('cloudinary');
        if ($isActiveCloudinary) {
            $cloudinaryModel = new CloudinaryVideoEntryModel();
            $adVideo = $cloudinaryModel::query()->where('adv', $this->getObject()->id)->first();
            if ($adVideo != null) {
                return $adVideo->url;
            } else {
                return null;
            }

        }
        return null;

    }

    public function getAdvsList($attributes)
    {
        return \route('visiosoft.module.advs::list', $attributes);
    }

    public function isCorporate()
    {
        $user_id = $this->getObject()->created_by;
        if ($user_id->register_type != null) {
            return $user_id->register_type;
        } else {
            return 1;
        }

    }

    public function priceFormat($adv)
    {
        $advModel = new AdvModel();
        return $advModel->priceFormat($adv->getObject());
    }
}
