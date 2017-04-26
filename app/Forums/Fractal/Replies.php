<?php

namespace App\Fourms\Fractal;

use App\Fourms\Reply;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class Replies extends TransformerAbstract
{
	protected $defaultIncludes = ['author', 'attachments'];
	
	public function transform(Reply $reply)
	{
		return [
			'id' => $reply->id,
			'reply' => $reply->reply,
			'hidden' => $reply->is_hidden? true:false,
			'attachment_count' => $reply->attachments->count(),
			'created' => $reply->created_at > Carbon::now()->addDay()? $reply->created_at->diffForHumans:$reply->created_at->toDayDateTimeString(),
			'updated' => $reply->created_at != $reply->updated_at? $reply->updated_at->toDayDateTimeString():null,
		];
	}

	/**
     *  Include Author
     *
     * @return League\Fractal\ItemResource
     */
    public function includeAuthor(Reply $reply)
    {
        return $this->item($reply->user, new Author);
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