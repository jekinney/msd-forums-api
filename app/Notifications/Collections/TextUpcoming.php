<?php

namespace App\Notifications\Collections;

use App\Collections\BaseCollection;

class TextUpcoming extends BaseCollection
{
	protected function setDataArray($notification)
	{
		return [
			'id' => $notification->id,
			'message' => $notification->message,
			'send_at' => $notification->send_at->toDayDateTimeString(),
			'recipients_count' => $notification->recipients_count?? null,
		];
	}
}