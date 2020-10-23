<?php namespace Visiosoft\AdvsModule\OptionHandler;

use Anomaly\SelectFieldType\SelectFieldType;
use Visiosoft\CatsModule\Category\Contract\CategoryRepositoryInterface;

class CategoriesOptions
{
	private $categoryRepository;

	public function __construct(CategoryRepositoryInterface $categoryRepository)
	{
		$this->categoryRepository = $categoryRepository;
	}

	public function handle(SelectFieldType $fieldType)
	{
		$categories = $this->categoryRepository->mainCats();
		$options[] = $categories->pluck('name', 'id');
		$fieldType->setOptions($options);
	}
}