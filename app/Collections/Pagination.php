<?php

namespace App\Collections;

class Pagination
{
	public function reply($collection)
	{
		return [
			'count' => $collection->count(),
			'current_pages' => $collection->currentPage(),
			'first_item' => $collection->firstItem(),
			'has_more_pages' => $collection->hasMorePages(),
			'last_item' => $collection->lastItem(),
			'last_page' => $collection->lastPage(),
			'next_page_url' => $collection->nextPageUrl(),
			'items_per_page' => $collection->perPage(),
			'previous_page_url' => $collection->previousPageUrl(),
			'total' => $collection->total(),
		];
	}
}