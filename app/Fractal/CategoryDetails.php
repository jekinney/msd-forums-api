<?php

namespace App\Fractal;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryDetails extends TransformerAbstract
{
	public function transform(Category $category)
	{
		return [
			'id' => $category->id,
			'name' => $category->name,
			'order' => $category->order,
			'hidden' => $category->is_hidden,
			'channel_count' => $category->channels_count,
			'thread_count' => $category->threads_count,
		];
	}
}