<?php

namespace App\Fractal;

use App\Channel;
use League\Fractal\TransformerAbstract;

class AllChannels extends TransformerAbstract
{
	public function transform(Channel $channel)
	{
		return [
			'id' => $channel->id,
            'slug' => $channel->slug,
			'name' => $channel->name,
			'hidden' => $channel->is_hidden,
            'order' => $channel->order,
            'thread_count' => $channel->threads_count,
            'reply_count' => $channel->replies_count,
            'last_thread_date' => $channel->threads()->select('created_at')->last();
            'last_reply_date' => $channel->replies()->select('created_at')->last();
            'editing' => false,
		];
	}
}