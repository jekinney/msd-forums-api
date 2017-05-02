<?php

namespace App\Forums\Collections;

use App\Collections\BaseCollection;

class ThreadList extends BaseCollection
{
	protected function setDataArray($thread)
	{
		return [
			'id' => $thread['id'],
        	'slug' => $thread['slug'],
			'title' => $thread['title'],
			'body' => $thread['body'],
			'reported' => $thread['reported'],
			'created' => $thread['created_at']->toDayDateTimeString(),
			'updated' => $thread['created_at'] == $thread['updated_at']? null:$thread['updated_at']->toDayDateTimeString(),
			'hidden' => $thread['is_hidden']? true:false,
			'reply_count' => $thread['replies']->count(),
        	'attachment_count' => $thread['attachments']->count(),
        	'author' => $thread['user']->name,
  			'author_company' => $thread['user']->company,
        	'channel_name' => $thread['channel']->name,
        	'channel_id' => $thread['channel']->id
		];
	}
}