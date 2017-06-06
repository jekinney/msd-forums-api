<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\Collections\TextPastNotifications;
use App\Notifications\Collections\TextUpcomingNotifications;

class Notification extends Model
{
    protected $fillable = [
		'type',
		'from',
		'subject',
		'message',
		'send_at',
        'end_now',
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


    /**
     * Get all upcoming for display
     * transformed with fractal
     *
     * @return array
     */
    public function upcoming()
    {
        return $this->withCount('recipients')
                ->where('send_at', '>', Carbon::now())
                ->get();
    }

    /**
     * Get all text for display
     *
     * @return array
     */
    public function text() 
    {
        $upcoming = new TextUpcomingNotifications();

        $texts = $this->withCount('recipients')
            ->where('type', 'text')
            ->get();

        return ['upcoming' => $upcoming->reply($texts->where('send_at', '<=', Carbon::now())) ];
    }

    /**
     * Get all upcoming for display
     * transformed with fractal
     *
     * @return array
     */
    public function updateOrCreate($request)
    {
    	if($request->has('id')) {

    		$notification = $this->find($request->id);
    		$notification->update($this->setDataArray($request));

    	} else {

    		$notification = $this->create($this->setDataArray($request));

    	}

        return $this->attachRecipients($notification->load('recipients'), $request);
    }

    public function remove($id) 
    {
        $notification = $this->with('recipients')->find($id);
        $this->detachRecipients($notification);
        return $notification->delete();
    }

    /**
     * Protected helpers
     *
     * Get all upcoming for display
     * transformed with fractal
     *
     * @param Request $request
     *
     * @return array
     */
    protected function setDataArray($request)
    {
    	return [
			'type' => $request->type,
			'subject' => $request->subject,
			'message' => $request->message,
			'send_at' => $request->send_at? Carbon::parse($request->send_at):null,
            'send_now' => $request->send_now
    	];
    }

    /**
     * Get all upcoming for display
     * transformed with fractal
     * @param Notification $notification
     * @param Request $request
     *
     * @return array
     */
    protected function attachRecipients($notification, $request)
    {
        $this->detachRecipients($notification);

        foreach($request->recipients as $recipient) {

            $contact = $notification->type == 'text'? $recipient['phone']:$recipient['email'];

            $notification->recipients()->create([
                'uid' => $notification->type.'-'.str_random(20),
                'name' =>  $recipient['name'],
                'phone' => $recipient['phone'],
                'email' => $recipient['email'],
            ]);

        }

        return $notification;
    }

    protected function detachRecipients($notification) 
    {
         if(count($notification->recipients) > 0) {
            foreach($notification->recipients as $recipient) {
                $recipient->delete();
            }
        }
    }
}
