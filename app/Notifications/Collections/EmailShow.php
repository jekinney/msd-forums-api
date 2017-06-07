<?php

namespace App\Notifications\Collections;

use App\Collections\BaseCollection;

class EmailShow extends BaseCollection
{
	protected function setDataArray($email)
	{
		$recipients = new RecipientsDetails();

		return [
			'id' => $email->id,
			'subject' => $email->subject,
			'message' => $email->message,
			'send_at' => $email->send_at->toDayDateTimeString(),
			'started_at' => $email->started_at? $email->started_at->toDayDateTimeString():null,
			'completed_at' => $email->completed_at? $email->completed_at->toDayDateTimeString():null,
			'notes' => $email->notes,
			'send_now' => $email->send_now? true:false,
			'recipients' => $recipients->reply($email->recipients),
			'created_at' => $email->created_at->toDayDateTimeString(),
		];
	}
}