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
    protected $availableIncludes = ['replies', 'attachments'];

    protected $defaultIncludes = ['channel', 'author'];

	public function transform(Thread $thread)
	{
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
            'attachment_count' => $thread->attachments_count,
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
     * Include channel
     *
     * @return League\Fractal\ItemResource
     */
    public function includeChannel(Thread $thread)
    {
        return $this->item($thread->channel, new Channels);
    }

    /**
     *  Include Author
     *
     * @return League\Fractal\ItmeResource
     */
    public function includeAuthor(Thread $thread)
    {
        return $this->item($thread->user, new Author);
    }

    /**
     *  Include Attachments
     *
     * @return League\Fractal\ItmeResource
     */
    public function includeAttachments(Thread $thread)
    {
        return $this->item($thread->attachments, new Attachments);
    }
}