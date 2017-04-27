<?php

namespace App\Helpers;

class PhoneNumber
{
	public static function setForText($number)
	{
		$number = preg_replace('/\D/', '', $number);

		if(preg_match("/^1/", $number)) {
			return $number;
		}

		return '1'.$number;
	}
}