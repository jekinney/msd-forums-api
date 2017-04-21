<?php

namespace App\Fractal;

use App\User;
use League\Fractal\TransformerAbstract;

class Author extends TransformerAbstract
{
	/**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['threads', 'replies'];

	public function transform(User $user)
	{
		return [
            'id' => $user->id,
			'name' => $user->name,
			'company' => $user->company,
		];
	}

	/**
     * Include Replies
     *
     * @return League\Fractal\ItemResource
     */
    public function includeReplies(User $user)
    {
        return $this->collection($user->replies, new Replies);
    }

    /**
     * Include Threads
     *
     * @return League\Fractal\ItemResource
     */
    public function includeChannel(User $user)
    {
        return $this->collection($user->threads, new Threads);
    }
}