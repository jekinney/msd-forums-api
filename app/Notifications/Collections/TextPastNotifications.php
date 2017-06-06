<?php

namespace App\Notifications\Collections;

use App\Collections\BaseCollection;

class TextPastNotifications extends BaseCollection
{
	protected function setDataArray($text)
	{
		return [
			'id' => $text->id,
			'message' => $text->message,
			'send_at' => $text->send_at->toDayDateTimeString(),
			'started_at' => $text->started_at->toDateTimeString(),
			'ended_at' => $text->ended_at? $text->ended_at->toDateTimeString():null,
			'notes' => $text->notes,
			'send_now' => $text->send_now? true:false,
			'recipients_count' => $text->recipients_count?? null,
		];
	}
}