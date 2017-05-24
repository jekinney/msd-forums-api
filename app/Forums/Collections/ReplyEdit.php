<?php

namespace App\Forums\Collections;

use App\Collections\BaseCollection;

class ReplyEdit extends BaseCollection
{
	protected function setDataArray($reply)
	{
		return [
			'id' => $reply['id'],
			'thread_id' => $reply['thread_id'],
			'user_id' => $reply['user_id'],
			'reply' => $reply['reply'],
			'attachment_count' => $reply['attachments']->count(),
			'attachments' => $this->setAttachments($thread['attachments']),
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