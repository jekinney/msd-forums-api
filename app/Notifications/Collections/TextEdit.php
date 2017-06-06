<?php

namespace App\Notifications\Collections;

use App\Collections\BaseCollection;

class TextEdit extends BaseCollection
{
	protected function setDataArray($text)
	{
		$recipients = new Recipients();

		return [
			'id' => $text->id,
			'message' => $text->message,
			'send_at' => $text->send_at->toDateTimeString(),
			'send_now' => $text->send_now? true:false,
			'recipients' => $recipients->reply($text->recipients),
		];
	}
}