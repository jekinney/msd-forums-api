<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['user_id', 'thread_id', 'body', 'hidden', 'reported'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    
    public function thread()
    {
    	return $this->belongsTo(Thread::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
