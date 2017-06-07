<?php

namespace App\Notifications\Collections;

use App\Collections\BaseCollection;

class TextUpcoming extends BaseCollection
{
	protected function setDataArray($text)
	{
		return [
			'id' => $text->id,
			'message' => $text->message,
			'send_at' => $text->send_at->toDayDateTimeString(),
			'recipients_count' => $text->recipients_count?? null,
			'created_at' => $text->created_at->toDayDateTimeString(),
		];
	}
}