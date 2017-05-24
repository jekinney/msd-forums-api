<?php

namespace App\Forums\Collections;

use App\Collections\BaseCollection;

class ThreadEdit extends BaseCollection
{
	protected function setDataArray($thread)
	{	
		return [
			'id' => $thread['id'],
			'channel_id' => $thread['channel_id'],
			'user_id' => $thread['user_id'],
			'title' => $thread['title'],
			'body' => $thread['body'],
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