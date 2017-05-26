<?php

namespace App\Forums\Collections;

use App\Collections\BaseCollection;

class AttachmentsList extends BaseCollection
{
	protected function setDataArray($attachment)
	{	
		return [
			'id' => $attachment['id'],
			'type' => $attachment['file_type'],
			'name' => $attachment['name'],
			'path' => env('APP_URL').preg_replace('/public/', '', $attachment['full_path']),
		];
	}
}