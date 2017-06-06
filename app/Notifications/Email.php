<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\Traits\Recipients;
use App\Notifications\Traits\MailgunEmail;
use App\Notifications\Collections\EmailPast;
use App\Notifications\Collections\EmailShow;
use App\Notifications\Collections\EmailEdit;
use App\Notifications\Collections\EmailUpcoming;

class Email extends Model
{
	use MailgunEmail, Recipients;

	protected $guarded = [];
	
	protected $dates = ['send_at', 'started_at', 'completed_at'];

    public function getAll()
    {
    	$upcoming = new EmailUpcoming();
    	$past = new EmailPast();

        return [
        	'upcoming' => $upcoming->reply(
        		$this->withCount('recipients')->whereDate('send_at', '>', Carbon::now())->get()
        	),
        	'past' => $past->reply(
        		$this->withCount('recipients')->whereDate('send_at', '<', Carbon::now())->get()
        	)
        ];
    }

    public function findByIdForEdit($id) 
    {
    	$email = new EmailEdit();

    	return $email->reply($this->with('recipients')->find($id));
    }

    public function findByIdForShow($id) 
    {
    	$email = new EmailShow();

    	return $email->reply($this->with('recipients')->find($id));
    }
}