<?php

namespace App\Fractal;

use App\Attachment;
use League\Fractal\TransformerAbstract;

class Attachments extends TransformerAbstract
{
	public function transform(Attachment $attachment)
	{
		return [
			'path' => $attachment->path,
			'full_path' => $attachment->full_path;
		];
	}
}