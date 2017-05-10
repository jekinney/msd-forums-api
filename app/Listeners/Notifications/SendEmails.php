<?php

namespace App\Listeners\Notifications;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Notifications\Email;
use App\Mail\Notifications\Basic;
use Illuminate\Support\Facades\Mail;
use App\Events\Notifications\ProcessNotification;

class SendEmails
{
    protected $email;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Handle the event.
     *
     * @param  ProcessNotification  $event
     * @return void
     */
    public function handle(ProcessNotification $event)
    {
        if($event->notification->type == 'email') {

            $event->notification->update(['started_at' => Carbon::now()]);

            foreach($event->notification->recipients as $recipient) {

                $recipient->update(['sent_at' => Carbon::now(), 'status' => 'sending']);

                try {
                    Mail::to($recipient->connection)->send(new Basic($event->notification, $recipient));
                    $recipient->update(['confirmed_at' => Carbon::now()]);
                } catch (exception $e) {
                    $recipient->update([
                        'confirmed_at' => Carbon::now(), 
                        'status' => 'failed',
                        'notes' => $e
                    ]);
                }

            }

            $event->notification->update(['completed_at' => Carbon::now()]);
        }
    }
}
