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
		'connection',
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

    protected function setDataArray($notification, $recipients) {
    	return [
	    	'uid' => $notification->type.'-'.str_random(20),
    		'notification_id' => $notification->id,
    		'name' => $recipients->name,
    		'connection' => $notification->type == 'text'? $recipient->phone:$recipient->email
    	];
    }
}
