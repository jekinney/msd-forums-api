<?php

namespace App\Fourms\Fractal;

use App\Fourms\Thread;
use League\Fractal\TransformerAbstract;

class ThreadBasic extends TransformerAbstract
{
	public function transform(Thread $thread)
	{
		return [
			'title' => $thread->title,
		];
	}
}