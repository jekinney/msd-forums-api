<?php

namespace App\Notifications\Collections;

use App\Collections\BaseCollection;

class Recipients extends BaseCollection
{
	protected function setDataArray($recipient)
	{
		return [
			'uid' => $recipient->uid,
			'name' => $recipient->name,
			'phone' => $recipient->phone,
			'email' => $recipient->email,
		];
	}
}