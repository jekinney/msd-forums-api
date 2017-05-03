<?php

namespace App\Forums\Collections;

use Carbon\Carbon;
use App\Collections\BaseCollection;

class ReplyList extends BaseCollection
{
	protected function setDataArray($reply)
	{
		return [
			'id' => $reply['id'],
			'thread_id' => $reply['thread_id'],
			'author' => $reply['user']->name,
			'author_company' => $reply['user']->company,
			'reply' => $reply['reply'],
			'hidden' => $reply['is_hidden']? true:false,
			'attachment_count' => $reply['attachments']->count(),
			'created' => $reply['created_at'] > Carbon::now()->addDay()? $reply['created_at']->diffForHumans:$reply['created_at']->toDayDateTimeString(),
			'updated' => $reply['created_at'] != $reply['updated_at']? $reply['updated_at']->toDayDateTimeString():null,
		];
	}
}