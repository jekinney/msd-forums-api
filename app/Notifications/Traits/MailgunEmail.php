<?php

namespace App\Notifications\Traits;

use Carbon\Carbon;
use App\Mail\Notifications\Test;
use App\Mail\Notifications\Basic;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

trait MailgunEmail
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

	public function sendBasic($email, $recipient)
	{
		$recipient->update(['sent_at' => Carbon::now(), 'status' => 'sending']);

        Mail::to($recipient->email)->send(new Basic($email,$recipient));

        $recipient->update(['status' => 'sent']);
	}


	public function checkAndSend($stop) 
	{
        $emails = $this->with('recipients')->where('send_at', '<', $stop)->whereNull('started_at')->get();

        if($emails) {
        	foreach($emails as $email) {

				$email->update(['started_at' => Carbon::now()]);

				foreach($email->recipients as $recipient) {
					$this->sendBasic($email, $recipient);
				}

				$email->update(['completed_at' => Carbon::now(), 'notes' => 'Completed']);
	        }
	    }

        return $emails->count();
	}
}