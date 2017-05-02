<?php

namespace App\Forums\Collections;

use App\Collections\BaseCollection;

class ChannelList extends BaseCollection
{
	public function setDataArray($channel)
	{
		return [
			'id' => $channel['id'],
			'name' => $channel['name'],
			'order' => $channel['order'],
		];
	}
}