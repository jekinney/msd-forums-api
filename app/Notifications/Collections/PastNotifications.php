<?php

namespace App\Notifications\Collections;

use App\Collections\BaseCollection;

class PastNotifications extends BaseCollection
{
	protected function setDataArray($notification)
	{
		return [
			'id' => $notification->id,
			'type' => ucfirst($notification->type),
			'subject' => $notification->subject,
			'send_at' => $notification->send_at->toDayDateTimeString(),
			'started_at' => $notification->started_at? $notification->started_at->toDayDateTimeString():'Error',
			'completed_at' => $notification->completed_at? $notification->completed_at->toDayDateTimeString():'Error',
			'has_notes' => $notification->notes? true:false,
			'recipients_count' => $notification->recipients_count?? null,
		];
	}
}