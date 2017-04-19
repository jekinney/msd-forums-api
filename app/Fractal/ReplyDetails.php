<?php

namespace App\Fractal;

use App\Reply;
use League\Fractal\TransformerAbstract;

class ReplyDetails extends TransformerAbstract
{
	public function transform(Reply $reply)
	{
		return [
			'id' => $reply->id,
			'thread_id' => $reply->thread_id,
			'user_id' => $reply->user_id,
			'reply' => $reply->reply,
		];
	}

}