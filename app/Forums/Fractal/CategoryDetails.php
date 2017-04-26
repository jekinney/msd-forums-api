<?php

namespace App\Fourms\Fractal;

use App\Fourms\Category;
use League\Fractal\TransformerAbstract;

class CategoryDetails extends TransformerAbstract
{
	public function transform(Category $category)
	{
		return [
			'id' => $category->id,
			'slug' => $category->slug,
			'name' => $category->name,
			'order' => $category->order,
			'hidden' => $category->is_hidden,
			'channel_count' => $category->channels_count,
			'thread_count' => $category->threads_count,
		];
	}
}
