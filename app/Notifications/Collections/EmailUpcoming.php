<?php

namespace App\Notifications\Collections;

use App\Collections\BaseCollection;

class EmailUpcoming extends BaseCollection
{
	protected function setDataArray($email)
	{
		return [
			'id' => $email->id,
			'subject' => $email->subject,
			'send_at' => $email->send_at->toDayDateTimeString(),
			'recipients_count' => $email->recipients_count?? null,
		];
	}
}