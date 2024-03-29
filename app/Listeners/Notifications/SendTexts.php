<?php

namespace App\Listeners\Notifications;

use Nexmo;
use Carbon\Carbon;
use App\Notifications\Text;
use App\Helpers\PhoneNumber;
use App\Events\Notifications\ProcessNotification;

class SendTexts
{
    protected $text;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Text $text)
    {
        $this->text = $text;
    }

    /**
     * Handle the event.
     *
     * @param  ProcessNotification  $event
     * @return void
     */
    public function handle(ProcessNotification $event)
    {
        if($event->notification->type == 'text') {

            $event->notification->update(['started_at' => Carbon::now(), 'status' => 'sending']);

            foreach($event->notification->recipients as $recipient) {

                if(strlen($recipient->phone) > 9) {
                    try {

                        $request = Nexmo::message()->send([
                            'to' => PhoneNumber::setForText($recipient->connection),
                            'from' => env('NEXMO_PHONE'),
                            'text' => $event->notification->message
                        ]);

                       $this->setReturnRequest($request, $recipient);

                    } catch (Exception $e) {
                        $recipient->update(['status' => 'Error', 'notes' => $e]);
                    }   
                }
            }

            $event->notification->update(['completed_at' => Carbon::now(), 'status' => 'Sent']);
        }
    }

    protected function setReturnRequest($request, $recipient)
    {
        $message = $request->getResponseData()['messages'][0];

        return $recipient->update([
            'message_id' => $message['message-id'],
            'status' => $message['status'],
            'started_at' => \Carbon\Carbon::now(),
            'price' => $message['message-price']
        ]);
    }
}
