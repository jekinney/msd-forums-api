<?php

namespace App\Fractal;

use App\Category;
use League\Fractal\TransformerAbstract;

class BasicCategory extends TransformerAbstract
{
	public function transform(Category $category)
	{
		return [
			'id' => $category->id,
			'name' => $category->name,
		];
	}
}
