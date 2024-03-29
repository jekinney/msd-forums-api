<?php

namespace App\Notifications\Collections;

use App\Helpers\PhoneNumber;
use App\Collections\BaseCollection;

class RecipientsDetails extends BaseCollection
{
	protected function setDataArray($recipient)
	{
		return [
			'name' => $recipient->name,
			'phone' => PhoneNumber::setForText($recipient->phone),
			'email' => $recipient->email,
			'message_id' => $recipient->message_id,
			'sent_at' => $recipient->sent_at? $recipient->sent_at->toDayDateTimeString():null,
			'confirmed_at' => $recipient->confirmed_at? $recipient->confirmed_at->toDayDateTimeString():null,
			'status' => $recipient->status,
			'notes' => $recipient->notes,
		];
	}
}