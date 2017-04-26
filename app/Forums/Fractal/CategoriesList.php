<?php

namespace App\Fourms\Fractal;

use App\Fourms\Category;
use League\Fractal\TransformerAbstract;

class CategoriesList extends TransformerAbstract
{
	public function transform(Category $category)
	{
		return [
			'id' => $category->id,
			'name' => $category->name,
		];
	}
}