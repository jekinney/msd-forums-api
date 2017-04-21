<?php

namespace App\Fractal;

use App\Reply;
use League\Fractal\TransformerAbstract;

class ReplyDetails extends TransformerAbstract
{
	protected $defaultIncludes = ['attachments'];

	public function transform(Reply $reply)
	{
		return [
			'id' => $reply->id,
			'thread_id' => $reply->thread_id,
			'user_id' => $reply->user_id,
			'reply' => $reply->reply,
			'attachment_count' => $reply->attachments->count(),
		];
	}


    /**
     *  Include Attachments
     *
     * @return League\Fractal\CollectionResource
     */
    public function includeAttachments(Reply $reply)
    {
        return $this->collection($reply->attachments, new Attachments);
    }
}