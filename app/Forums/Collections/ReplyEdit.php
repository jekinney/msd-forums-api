<?php

namespace App\Forums\Collections;

use App\Collections\BaseCollection;

class ReplyEdit extends BaseCollection
{
	protected function setDataArray($reply)
	{
		return [
			'id' => $reply['id'],
			'reply' => $reply['reply'],
			'thread_id' => $reply['thread_id'],
			'thread_title' => $reply['thread']['title']
		];
	}
}