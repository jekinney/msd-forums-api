<?php

namespace App\Notifications\Collections;

use App\Collections\BaseCollection;

class Notifications extends BaseCollection
{
	protected function setDataArray($notification)
	{
		return [
			'id' => $notification->id,
			'type' => $notification->type,
			'subject' => $notification->subject,
			'message' => $notification->message,
			'send_at' => $notification->send_at->format('Y-m-d\TH:i:s'),
		];
	}
}