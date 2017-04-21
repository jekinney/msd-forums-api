<?php

namespace App\Fractal;

use App\Attachment;
use League\Fractal\TransformerAbstract;

class Attachments extends TransformerAbstract
{
	public function transform(Attachment $attachment)
	{
		return [
			'id' => $attachment->id,
			'path' => $attachment->full_path,
			'name' => $attachment->name,
		];
	}
}