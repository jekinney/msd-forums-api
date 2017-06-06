<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\Traits\NeximoTexts;
use App\Notifications\Collections\TextPastNotifications;
use App\Notifications\Collections\TextUpcomingNotifications;

class Text extends Model
{
	use NeximoTexts;

    protected $guarded = [];

    protected $dates = ['send_at', 'started_at', 'completed_at'];

    public function recipients()
    {
        return $this->morphMany(Recipient::class, 'recipients');
    }

    public function getAll()
    {
    	$upcoming = new TextUpcomingNotifications();
    	$past = new TextPastNotifications();

        $texts = $this->withCount('recipients')
            ->get();

        return [
        	'upcoming' => $upcoming->reply(
        		$this->withCount('recipients')->whereDate('send_at', '>', Carbon::now())->get()
        	),
        	'past' => $past->reply(
        		$this->withCount('recipients')->whereDate('send_at', '<', Carbon::now())->get()
        	)
        ];
    }
}