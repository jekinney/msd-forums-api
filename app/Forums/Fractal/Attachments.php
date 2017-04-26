<?php

namespace App\Fourms\Fractal;

use App\Fourms\Attachment;
use League\Fractal\TransformerAbstract;

class Attachments extends TransformerAbstract
{
	public function transform(Attachment $attachment)
	{
		return [
			'id' => $attachment->id,
			'path' => $attachment->full_path,
			'name' => $attachment->name,
			'type' => $attachment->file_type,
		];
	}
}