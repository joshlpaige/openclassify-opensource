<?php namespace Visiosoft\CatsModule\Category;

use Anomaly\Streams\Platform\Model\Cats\CatsCategoryEntryModel;
use Visiosoft\CatsModule\Category\Contract\CategoryRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class CategoryRepository extends EntryRepository implements CategoryRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var CategoryModel
     */
    protected $model;

    /**
     * Create a new CategoryRepository instance.
     *
     * @param CategoryModel $model
     */
    public function __construct(CategoryModel $model)
    {
        $this->model = $model;
    }

    public function findById($id)
    {
        return $this->model->orderBy('created_at', 'DESC')->where('cats_category.id', $id)->first();
    }

    public function mainCats()
    {
        return $this->model->where('parent_category_id', null)->where('deleted_at', null)->orderBy('sort_order')->get();
    }

    public function getItem($cat)
    {
        return $this->model->where('cats_category.id', $cat)->first();
    }

    public function getCatById($id)
    {
        return $this->model->where('cats_category.id', $id)->where('deleted_at', null)->orderBy('sort_order')->get();
    }

    public function getSubCatById($id)
    {
        return $this->model->where('parent_category_id', $id)->where('deleted_at', null)->orderBy('sort_order')->get();
    }

    public function getSingleCat($id)
    {
        return CatsCategoryEntryModel::query()->where('cats_category.id', $id)->first();
    }

    public function findBySlug($slug)
    {
        return $this->model->orderBy('created_at', 'DESC')->where('slug', $slug)->first();
    }

    public function getCategories()
    {
        return $this->model->orderBy('sort_order')->get();
    }

    public function DeleteCategories($id)
    {
        $sub_categories = $this->model->getAllSubCategories($id);
        if (count($sub_categories)) {
            $this->model
                ->whereIn('id', array_merge($sub_categories, [$id]))
                ->delete();
        } else
            $this->model->find($id)->delete();
    }
}
