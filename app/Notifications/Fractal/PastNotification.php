<?php

namespace App\Notifications\Fractal;

use App\Notifications\Notification;
use League\Fractal\TransformerAbstract;

class PastNotification extends TransformerAbstract
{
	public function transform(Notification $notification)
	{
		return [
			'id' => $notification->id,
			'type' => ucfirst($notification->type),
			'subject' => $notification->subject,
			'send_at' => $notification->send_at->toDayDateTimeString(),
			'started_at' => $notification->started_at->toDayDateTimeString(),
			'completed_at' => $notification->completed_at? $notification->completed_at->toDayDateTimeString():null,
			'has_notes' => $notification->notes? true:false,
			'recipients_count' => $notification->recipients_count?? null,
		];
	}
}