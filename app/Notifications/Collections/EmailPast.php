<?php

namespace App\Notifications\Collections;

use App\Collections\BaseCollection;

class EmailPast extends BaseCollection
{
	protected function setDataArray($email)
	{
		return [
			'id' => $email->id,
			'subject' => $email->subject,
			'send_at' => $email->send_at->toDayDateTimeString(),
			'started_at' => $email->started_at? $email->started_at->toDateTimeString():null,
			'ended_at' => $email->ended_at? $email->ended_at->toDateTimeString():null,
			'notes' => $email->notes,
			'send_now' => $email->send_now? true:false,
			'recipients_count' => $email->recipients_count?? null,
		];
	}
}