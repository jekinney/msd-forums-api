<?php

namespace App\Fractal;

use App\Category;
use League\Fractal\TransformerAbstract;

class Categories extends TransformerAbstract
{
	/**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['threads'];

	public function transform(Category $category)
	{
		return [
			'id' => $category->id,
			'name' => $category->name,
			'description' => $category->hide_description? $category->descrioption:null,
			'hidden' => $category->hidden? true:false,
		];
	}

	/**
     * Include Author
     *
     * @return League\Fractal\ItemResource
     */
    public function includeThreads(Category $category)
    {
        return $this->collection($category->threads, new Threads);
    }
}