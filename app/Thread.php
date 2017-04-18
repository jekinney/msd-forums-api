<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
     /**
     * Fillable fields for mass assignment
     */
    protected $fillable = ['user_id', 'channel_id', 'slug', 'title', 'body', 'is_hidden', 'reports'];

     /**
     * Get the threads author.
     */
    public function user()
    {
    	return $this->belongsTo(User::class);
    }

     /**
     * Get the threads channel.
     */
    public function channel()
    {
    	return $this->belongsTo(Channel::class);
    }

     /**
     * Get all of the threads replies.
     */
    public function replies()
    {
    	return $this->hasMany(Reply::class);
    }

     /**
     * Get all of the threads attachments.
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

     /**
     * Get all of the reported threads.
     */
    public function reported()
    {
        return $this->morphMany(Reported::class, 'reportable');
    }

     /**
     * Get all not hidden threads with associated channel
     * and reply count in a paginated list
     *
     * @param int $amount
     * @return collection Thread
     */
    public function newestActive($amount = 10)
    {
        return $this->with('channel')->withCount('replies')->where('is_hidden', 0)->latest()->paginate($amount);
    }

     /**
     * Insert or update a thread
     *
     * @param  \Illuminate\Http\Request  $request
     * @return object Thread
     */
    public function addOrUpdate($request)
    {
        if($request->has('id')) {
            $thread = $this->find($request->id);
            $thread->update($this->dataArray($request));
            return $thread;
        } 
        return $this->create($this->dataArray($request));
    }

    /**
     * Normalize data array for update or create thread
     */
    public function dataArray($request)
    {
        return [
            'channel_id' => $request->channel_id,
            'user_id' => $request->user_id,
            'slug' => str_slug($request->title),
            'title' => $request->title,
            'body' => $request->body,
        ];
    }
}
