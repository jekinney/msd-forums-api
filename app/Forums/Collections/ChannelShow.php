<?php

namespace App\Forums\Collections;

use App\Collections\BaseCollection;

class ChannelShow extends BaseCollection
{
	public function setDataArray($channel)
	{
		$thread = new ThreadList();
		
		return [
			'id' => $channel->id,
			'name' => $channel->name,
			'threads' => $thread->reply($channel->threads),
		];
	}
}