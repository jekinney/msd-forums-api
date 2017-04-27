<?php

namespace App\Notifications\Fractal;

use App\Notifications\Notification;
use League\Fractal\TransformerAbstract;

class UpcomingNotification extends TransformerAbstract
{
	public function transform(Notification $notification)
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