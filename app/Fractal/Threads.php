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

    protected $defaultIncludes = ['basicCategory'];

	public function transform(Thread $thread)
	{
		return [
			'id' => $thread->id,
			'title' => $thread->title,
			'body' => $thread->body,
			'reported' => $thread->reported,
			'created' => $thread->created_at->toDayDateTimeString(),
			'updated' => $thread->created_at == $thread->updated_at? null:$thread->updated_at->toDayDateTimeString(),
			'hidden' => $thread->hidden? true:false,
			'reply_count' => $thread->replies->count(),
		];
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
     * Include category
     *
     * @return League\Fractal\ItemResource
     */
    public function includeBasicCategory(Thread $thread)
    {
        return $this->item($thread->category, new BasicCategory);
    }
}