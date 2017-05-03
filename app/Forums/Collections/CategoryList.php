<?php

namespace App\Forums\Collections;

use App\Collections\BaseCollection;

class CategoryList extends BaseCollection
{
	public function setDataArray($category)
	{
		return [
			'id' => $category['id'],
			'name' => $category['name'],
			'order' => $category['order'],
		];
	}
}