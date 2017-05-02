<?php

namespace App\Collections;

abstract class BaseCollection
{
	public function reply($collections)
	{
		if($collections) {
			$parent = get_parent_class($collections);
			
			if($parent == 'Illuminate\Pagination\AbstractPaginator' || $parent == 'Illuminate\Support\Collection') {
				$data = [];
				foreach($collections as $collection) {
					$data[] = $this->setDataArray($collection);
				}

				return $data;
			}
			return $this->setDataArray($collections);
		}
		return null;
	}
}