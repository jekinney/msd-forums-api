<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
		'type',
		'from',
		'subject',
		'message',
		'send_at',
		'errors',
		'started_at',
		'completed_at',
    ];

    protected $dates = ['send_at', 'started_at', 'completed_at'];

    public function recipients()
    {
    	return $this->hasMany(Recipient::class);
    }

    public function updateOrCreate($request)
    {
    	if($request->has('id')) {
    		$notification = $this->with('recipients')->find($request->id);
    		$notification->update($this->setDataArray($request));

    	} else {
    		$notification = $this->create($this->setDataArray($request));
    	}

    	if($request->has('send_now')) {
    		event(new sendNotificationNow($notification->load('recipients')));
    	}
    	return $notification;
    }

    protected function setDataArray($request)
    {
    	return [
			'type' => $request->type,
			'from' => 'Jason',
			'subject' => $request->subject,
			'message' => $request->message,
			'send_at' => $request->has('send_now')? Carbon::now():Carbon::parse($request->send_at),
			'started_at' => $request->has('send_now')? Carbon::now():null,
    	];
    }
}
