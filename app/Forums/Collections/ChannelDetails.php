<?php

namespace App\Forums\Collections;

use App\Collections\BaseCollection;

class ChannelDetails extends BaseCollection
{
	public function setDataArray($channel)
	{
		$replyCount = 0;

		foreach($channel->threads()->withCount('replies')->get() as $thread) {
			$replyCount = $thread->replies_count + $replyCount;
		};

		return [
			'id' => $channel['id'],
			'category_id' => $channel['category_id'],
			'category_name' => $channel['category']['name'],
			'name' => $channel['name'],
			'slug' => $channel['slug'],
			'order' => $channel['order'],
			'is_hidden' => $channel['is_hidden']? true:false,
			'created_at' => $channel['created_at']->toDayDateTimeString(),
			'updated_at' => $channel['updated_at']->toDayDateTimeString(),
			'thread_count' => $channel['threads_count'],
			'reply_count' => $replyCount,
		];
	}
}