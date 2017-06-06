<?php

namespace App\Notifications;

use Storage;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    protected $guarded = [];

    protected $dates = ['sent_at', 'confirmed_at'];

    public function updateStatus($request)
    {
        $recipients = $this->where('email', $request->recipient)
                            ->where('phone', $request->recipient)
                            ->get();

        foreach($recipients as $recipient) {
            if($recipient->message_id == $request->member_id) {
                $recipient->update(['status' => $request->event]);
            }
        }
        
        //$recipient = $recipients->orderBy('created_at', 'desc')->first();

        // return $recipient->update([
        //     'message_id' => $request->message_id, 
        //     'status' => $request->event
        // ]);
    }
}
