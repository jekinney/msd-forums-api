<?php

namespace App\Fractal;

use App\Thread;
use League\Fractal\TransformerAbstract;

class Threads extends TransformerAbstract
{
	/**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['replies'];

    protected $defaultIncludes = ['channel'];

	public function transform(Thread $thread)
	{
        if(!$thread->category->is_hidden) {
    		return [
    			'id' => $thread->id,
                'slug' => $thread->slug,
    			'title' => $thread->title,
    			'body' => $thread->body,
    			'reported' => $thread->reported,
    			'created' => $thread->created_at->toDayDateTimeString(),
    			'updated' => $thread->created_at == $thread->updated_at? null:$thread->updated_at->toDayDateTimeString(),
    			'hidden' => $thread->is_hidden? true:false,
    			'reply_count' => $thread->replies_count,
    		];
        }
	}

	/**
     * Include Replies
     *
     * @return League\Fractal\ItemResource
     */
    public function includeReplies(Thread $thread)
    {
        return $this->collection($thread->replies, new Replies);
    }

    /**
     * Include channel
     *
     * @return League\Fractal\ItemResource
     */
    public function includeChannel(Thread $thread)
    {
        return $this->item($thread->channel, new Channels);
    }
}