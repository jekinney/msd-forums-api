<?php

namespace App\Fractal;

use App\Reply;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class HiddenReplies extends TransformerAbstract
{
	protected $defaultIncludes = ['author', 'channel', 'category'];
	
	public function transform(Reply $reply)
	{
		return [
			'id' => $reply->id,
			'reply' => $reply->reply,
			'hidden' => $reply->hidden? true:false,
			'created' => $reply->created_at > Carbon::now()->addDay()? $reply->created_at->diffForHumans:$reply->created_at->toDayDateTimeString(),
			'updated' => $reply->created_at != $reply->updated_at? $reply->updated_at->toDayDateTimeString():null,
		];
	}

	/**
     *  Include Author
     *
     * @return League\Fractal\ItmeResource
     */
    public function includeAuthor(Reply $reply)
    {
        return $this->item($reply->user, new Author);
    }

    /**
     *  Include Channel
     *
     * @return League\Fractal\ItmeResource
     */
    public function includeChannel(Reply $reply)
    {
        return $this->item($reply->channel, new Channels);
    }

    /**
     *  Include Category
     *
     * @return League\Fractal\ItmeResource
     */
    public function includeCategory(Reply $reply)
    {
        return $this->item($reply->category, new CategoryDetails);
    }
}