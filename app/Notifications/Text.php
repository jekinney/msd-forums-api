<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\Traits\Recipients;
use App\Notifications\Traits\NeximoTexts;
use App\Notifications\Collections\TextEdit;
use App\Notifications\Collections\TextShow;
use App\Notifications\Collections\TextPast;
use App\Notifications\Collections\TextUpcoming;

class Text extends Model
{
	use NeximoTexts, Recipients;

    protected $guarded = [];

    protected $dates = ['send_at', 'started_at', 'completed_at'];

    public function getAll()
    {
    	$upcoming = new TextUpcoming();
    	$past = new TextPast();

        return [
        	'upcoming' => $upcoming->reply(
        		$this->withCount('recipients')->where('send_at', '>', Carbon::now())->get()
        	),
        	'past' => $past->reply(
        		$this->withCount('recipients')->where('send_at', '<', Carbon::now())->get()
        	)
        ];
    }

    /**
    * A notification (text, email) has recipients.
    *
    * @return \Illuminate\Database\Eloquent\Relations\MorphMany
    */
    public function recipientsWithPhone() 
    {
        return $this->morphMany(Recipient::class, 'recipients')->where('phone', '<>', null);
    }



    public function findByIdForEdit($id) 
    {
    	$text = new TextEdit();

    	return $text->reply($this->with('recipients')->find($id));
    }

    public function findByIdForShow($id) 
    {
    	$text = new TextShow();

    	return $text->reply($this->with('recipients')->find($id));
    }
}