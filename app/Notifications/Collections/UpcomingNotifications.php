<?php

namespace App\Notifications\Collections;

use App\Collections\BaseCollection;

class UpcomingNotifications extends BaseCollection
{
	protected function setDataArray($notification)
	{
		return [
			'id' => $notification->id,
			'type' => ucfirst($notification->type),
			'subject' => $notification->subject,
			'send_at' => $notification->send_at->toDayDateTimeString(),
			'recipients_count' => $notification->recipients_count?? null,
		];
	}
}