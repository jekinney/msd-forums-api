<?php

namespace App\Fractal;

use App\Reply;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class Replies extends TransformerAbstract
{
	protected $defaultIncludes = ['author'];
	
	public function transform(Reply $reply)
	{
		return [
			'body' => $reply->reply,
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
}