<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Mail\Notifications\Test;
use App\Mail\Notifications\Basic;
use Illuminate\Support\Facades\Mail;

class Email
{
	/**
	 * Send one plain test email
	 *
	 * @param object $notification
	 */
	public function sendTest($notification)
	{
		Mail::to($notification->from)->send(new Test($notification));
	}
}