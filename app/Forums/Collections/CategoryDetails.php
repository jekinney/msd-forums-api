<?php

namespace App\Forums\Collections;

use App\Collections\BaseCollection;

class CategoryDetails extends BaseCollection
{
	protected function setDataArray($category)
	{
		$counts = $this->setCount($category);

		return [
			'id' => $category['id'],
			'name' => $category['name'],
			'slug' => $category['slug'],
			'order' => $category['order'],
			'is_hidden' => $category['is_hidden']? true:false,
			'created_at' => $category['created_at']->toDayDateTimeString(),
			'updated_at' => $category['updated_at']->toDayDateTimeString(),
			'channel_count' => $category->threads->count(),
			'thread_count' => $counts['threads'],
			'reply_count' => $counts['replies'],
		];
	}

	protected function setCount($category)
	{
		$count = [
			'threads' => 0,
			'replies' => 0
		];

		if($channels = $category->channels()->with('threads')->withCount('threads')->get()) {
			foreach($channels as $channel) {
				$count['threads'] = $count['threads'] + $channel->threads_count;
				if($threads = $channel->threads()->withCount('replies')->get()) {
					foreach($threads as $thread) {
						$count['replies'] = $count['replies'] + $thread->replies_count;
					}
				}
			}
		}

		return $count;
	}
}