<?php

namespace App\Notifications;

use Storage;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    protected $fillable =[
    	'uid',
		'notification_id',
		'name',
		'email',
        'phone',
		'sent_at',
		'confirmed_at',
		'message_id',
		'status',
		'cost',
		'notes',
	];

    public function remove($notificationId) 
    {
    	$recipients = $this->where('notification_id', $notificationId)->get();
    	foreach($recipient as $recipients) {
    		$recipient->delete();
    	}
    }

    public function attachAll($notification, $recipients)
    {
    	foreach($recipient as $recipients) {
    		$this->create($this->setDataArray($notification, $recipient));
    	}
    }

    public function updateStatus($request)
    {
        $recipients = $this->where('email', $request->recipient)
                        ->where('phone', $request->recipient)
                        ->get();

        foreach($recipients as $recipient) {
            if($recipient->message_id == $request->member_id) {
                return $recipient->update(['status' => $request->event]);
            }
        }
        
        $recipient = $recipients->orderBy('created_at', 'desc')->first();

        return $recipient->update([
            'message_id' => $request->message_id, 
            'status' => $request->event
        ]);
    }

    protected function setDataArray($notification, $recipients) {
    	return [
	    	'uid' => $notification->type.'-'.str_random(20),
    		'notification_id' => $notification->id,
    		'name' => $recipients->name,
    		'connection' => $notification->type == 'text'? $recipient->phone:$recipient->email
    	];
    }
}
