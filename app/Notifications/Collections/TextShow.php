<?php

namespace App\Notifications\Collections;

use App\Collections\BaseCollection;

class TextShow extends BaseCollection
{
	protected function setDataArray($text)
	{
		$recipients = new RecipientsDetails();

		return [
			'id' => $text->id,
			'message' => $text->message,
			'send_at' => $text->send_at->toDayDateTimeString(),
			'started_at' => $text->started_at? $text->started_at->toDayDateTimeString():null,
			'completed_at' => $text->completed_at? $text->completed_at->toDayDateTimeString():null,
			'notes' => $text->notes,
			'send_now' => $text->send_now? true:false,
			'recipients' => $recipients->reply($text->recipients),
			'created_at' => $text->created_at->toDayDateTimeString(),
		];
	}
}