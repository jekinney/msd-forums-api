<?php

namespace App\Fractal;

use App\Attachment;
use League\Fractal\TransformerAbstract;

class Attachments extends TransformerAbstract
{
	public function transform(Attachment $thread)
	{
		return [
			'path' => $attachment->path,
		];
	}
}