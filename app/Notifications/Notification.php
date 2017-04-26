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
		'notes',
		'started_at',
        'errors',
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

    		$notification = $this->find($request->id);
    		$notification->update($this->setDataArray($request));

    	} else {
    		$notification = $this->create($this->setDataArray($request));
    	}

        return $this->attachRecipientsAndFireEvent($notification, $request);
    }

    public function isCompleted() 
    {
        return $this->update(['completed_at' => Carbon::now()]);
    }

    protected function setDataArray($request)
    {
    	return [
			'type' => $request->type,
			'from' => env('NEXMO_PHONE'),
			'subject' => $request->subject,
			'message' => $request->message,
			'send_at' => $request->has('send_now')? Carbon::now():Carbon::parse($request->send_at),
            'errors' => 'nothing',
    	];
    }

    protected function attachRecipients($notification, $request)
    {
        foreach($request->recipients as $recipient) {
            $notification->recipients()->create([
                'uid' => $notification->type.'-'.str_random(20),
                'name' => $recipients->name,
                'connection' => $notification->type == 'text'? $recipient->phone:$recipient->email
            ]);
        }
        return $notification->with('recipients')->fresh();
    }
}
