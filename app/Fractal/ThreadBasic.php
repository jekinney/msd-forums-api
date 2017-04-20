<?php

namespace App\Fractal;

use App\Thread;
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