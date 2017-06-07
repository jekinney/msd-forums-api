<?php
namespace App\Helpers;

class ValidateRecipients
{
	public static function check($recipients)
	{
		dd(json_decode($recipients, true));
	}
}