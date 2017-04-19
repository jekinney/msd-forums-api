<?php

namespace App\Fractal;

use App\Channel;
use League\Fractal\TransformerAbstract;

class ChannelDetails extends TransformerAbstract
{
	/**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['threads'];

	public function transform(Channel $channel)
	{
		return [
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
                'last_thread_date' => $lastThread? $lastThread->created_at->toDateTimeString():'None',
                'last_reply_date' => $lastReply? $lastReply->created_at->toDateTimeString():'None',
                'category_name' => $channel->category->name,
                'editing' => false,
            ];
	}

	/**
     * Include Threads
     *
     * @return League\Fractal\ItemResource
     */
    public function includeThreads(Channel $channel)
    {
        return $this->collection($channel->threads, new Threads);
    }

}