<?php

namespace App\Notifications\Traits;

use App\Helpers\PhoneNumber;
use App\Notifications\Recipient;

trait Recipients
{
	protected static function bootRecipients()
    {
        static::deleting(function ($model) {
            $model->recipients->each->delete();
        });
    }

    /**
    * A notification (text, email) has recipients.
    *
    * @return \Illuminate\Database\Eloquent\Relations\MorphMany
    */
    public function recipients() 
	{
		return $this->morphMany(Recipient::class, 'recipients');
	}

	 /**
     * add recipients to the current notification.
     *
     * @return Model
     */
    public function addRecipients($recipients)
    {
        $this->recipients->each->delete();
    	foreach($recipients as $recipient) {
        	$this->recipients()->create($this->setDataArray($recipient));
        }

        return $this;
    }

	/**
     * Get the number of recipients for the notification.
     *
     * @return integer
     */
    public function getRecipientsCountAttribute()
    {
        return $this->recipients->count();
    }

    protected function setDataArray($recipient)
    {
        return [
            'name' => $recipient['name'],
            'email' => $recipient['email'],
            'phone' => PhoneNumber::setForText($recipient['phone']),
        ];
    }
}