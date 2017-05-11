<?php

namespace App\Notifications;

use Illuminate\Support\Facades\Log;
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

	public function sendBasic($recipient, $notification)
	{
		$recipient->update(['sent_at' => Carbon::now(), 'status' => 'sending']);

        Mail::to($recipient->connection)->send(new Basic($notification));

        $recipient->update(['status' => 'sent']);
	}
}