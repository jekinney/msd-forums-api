<?php

namespace App\Fractal;

use App\Channel;
use League\Fractal\TransformerAbstract;

class AllChannels extends TransformerAbstract
{
	public function transform(Channel $channel)
	{
		$lastThread = $channel->threads()->orderBy('created_at', 'desc')->first();
		$lastReply = $channel->replies()->orderBy('created_at', 'desc')->first();

		return [
			'id' => $channel->id,
            'slug' => $channel->slug,
			'name' => $channel->name,
			'hidden' => $channel->is_hidden,
            'order' => $channel->order,
            'thread_count' => $channel->threads_count,
            'reply_count' => $channel->replies_count,
            'last_thread_date' => $lastThread? $lastThread->created_at->toDateTimeString():null,
            'last_reply_date' => $lastReply? $lastReply->created_at->toDateTimeString():null,
            'editing' => false,
		];
	}
}