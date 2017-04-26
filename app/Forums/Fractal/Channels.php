<?php

namespace App\Fourms\Fractal;

use App\Fourms\Channel;
use League\Fractal\TransformerAbstract;

class Channels extends TransformerAbstract
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
			'id' => $channel->id,
			'name' => $channel->name,
			'hidden' => $channel->is_hidden,
            'order' => $channel->order,
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