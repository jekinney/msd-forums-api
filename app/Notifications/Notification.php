<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\Fractal\PastNotification;
use App\Notifications\Fractal\NotificationDetails;
use App\Notifications\Fractal\UpcomingNotification;

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

    /**
     * Queries
     *
     * Get all notifications in two groups
     * Past and upcoming for display
     *
     * @return collection
     */
    public function getAll()
    {
        return collect([
            'upcoming' => $this->upcoming(),
            'past' => $this->past()
        ]);
    }

    /**
     * Get all upcoming for display
     * transformed with fractal
     *
     * @return array
     */
    public function upcoming()
    {
        return fractal($this->withCount('recipients')->where('send_at', '>', Carbon::now())->get(), new UpcomingNotification)->toArray();
    }

    /**
     * Get all past for display
     * transformed with fractal
     *
     * @return array
     */
    public function past() 
    {
        return fractal($this->withCount('recipients')->where('send_at', '<=', Carbon::now())->get(), new PastNotification)->toArray();
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

        return $this->attachRecipients($notification, $request);
    }

    /**
     * Set as completed
     *
     * @return boolean
     */
    public function isCompleted() 
    {
        return $this->update(['completed_at' => Carbon::now()]);
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
			'from' => env('NEXMO_PHONE'),
			'subject' => $request->subject,
			'message' => $request->message,
			'send_at' => $request->has('send_now')? Carbon::now():Carbon::parse($request->send_at),
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
        foreach($request->recipients as $recipient) {

            $notification->recipients()->create([
                'uid' => $notification->type.'-'.str_random(20),
                'name' =>  $recipient['name'],
                'connection' => $notification->type == 'text'? $recipient['phone']:$recipient['email']
            ]);

        }

        return $notification->load('recipients');
    }
}
