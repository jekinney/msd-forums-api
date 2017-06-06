<?php

namespace App\Notifications\Collections;

use App\Collections\BaseCollection;

class EmailEdit extends BaseCollection
{
	protected function setDataArray($email)
	{
		$recipients = new Recipients();

		return [
			'id' => $email->id,
			'subject' => $email->subject,
			'message' => $email->message,
			'send_at' => $email->send_at->toDateTimeString(),
			'send_now' => $email->send_now? true:false,
			'recipients' => $recipients->reply($email->recipients),
		];
	}
}