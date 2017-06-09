<?php

namespace App\Forums\Collections;

use App\Collections\BaseCollection;

class CategoryShow extends BaseCollection
{
	public function setDataArray($category)
	{
		$channel = new ChannelList();
		$thread = new ThreadList();

		return [
			'id' => $category->id,
			'name' => $category->name,
			'channels' => $channel->reply($category->channels),
			'threads' => $thread->reply($category->threads->where('is_hidden', 0)),			
		];
	}
}