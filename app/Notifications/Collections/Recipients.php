<?php

namespace App\Notifications\Collections;

use App\Helpers\PhoneNumber;
use App\Collections\BaseCollection;

class Recipients extends BaseCollection
{
	protected function setDataArray($recipient)
	{
		return [
			'name' => $recipient->name,
			'phone' => PhoneNumber::setForText($recipient->phone),
			'email' => $recipient->email,
		];
	}
}