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
			'user_id' => $reply['user_id'],
			'author' => $reply['user']->name,
			'author_company' => $reply['user']->company,
			'reply' => $reply['reply'],
			'hidden' => $reply['is_hidden']? true:false,
			'attachment_count' => $reply['attachments']->count(),
			'created' => $reply['created_at'] > Carbon::now()->addDay()? $reply['created_at']->diffForHumans:$reply['created_at']->toDayDateTimeString(),
			'updated' => $reply['created_at'] != $reply['updated_at']? $reply['updated_at']->toDayDateTimeString():null,
			'attachments' => $this->setAttachments($reply['attachments']),
		];
	}

	protected function setAttachments($attachments)
	{
		if(count($attachments) > 0) {
			foreach($attachments as $attachment) {
				$attach[] = [
					'id' => $attachment['id'],
					'type' => $attachment['file_type'],
					'name' => $attachment['name'],
					'path' => env('APP_URL').preg_replace('/public/', '', $attachment['full_path']),
				];
			}
			return $attach;
		}

		return null;
	}
}