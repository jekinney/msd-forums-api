<?php

namespace App\Forums;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['user_id', 'thread_id', 'reply', 'is_hidden', 'reported'];

    protected $casts = [
        'is_hidden' => 'boolean',
    ];
    
     /**
     * Get the replies author.
     */
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    
     /**
     * Get replies thread
     */
    public function thread()
    {
    	return $this->belongsTo(Thread::class);
    }

     /**
     * Get all of the replies attachments.
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

     /**
     * Get all of the reported replies.
     */
    public function reported()
    {
        return $this->morphMany(Reported::class, 'reportable');
    }

    public function updateOrCreate($request)
    {
        if($request->has('id')) {
            $reply = $this->find($request->id);
            $reply->update($this->setDataArray($request));
            return $reply;
        }

        return $this->create($this->setDataArray($request));
    }

    protected function setDataArray($request)
    {
        return [
            'thread_id' => $request->thread_id,
            'user_id' => $request->user_id,
            'reply' => $request->reply,
        ];
    }
}