<?php

namespace App\Forums;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
     /**
     * Fillable fields for mass assignment
     */
    protected $fillable = ['user_id', 'channel_id', 'slug', 'title', 'body', 'is_hidden', 'reports'];

    protected $casts = [
        'is_hidden' => 'boolean',
    ];
    
     /**
     * Get the threads author.
     */
    public function user()
    {
    	return $this->belongsTo(\App\User::class);
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
    public function activeByCategoryId($categoryId, $amount = 10)
    {
        return $this->whereHas('channel', function($q) use($categoryId) {
                $q->where('is_hidden', 0);
                $q->where('category_id', $categoryId);
            })->withCount('replies', 'attachments')
            ->with('user')
            ->where('is_hidden', 0)
            ->latest()
            ->paginate($amount);
    }

    public function activeByChannelId($channelId, $amount = 10)
    {
        return $this->with('user')
                ->withCount('replies', 'attachments')
                ->where('channel_id', $channelId)
                ->where('is_hidden', 0)
                ->latest()
                ->paginate($amount); 

    }

    public function show($id)
    {
        return $this->with('channel', 'user', 'attachments', 'replies', 'replies.user',  'replies.attachments')
                ->withCount('replies', 'attachments')
                ->find($id);
    }

    public function hidden() 
    {
         return $this->with('channel', 'user', 'attachments')
                ->withCount('replies', 'attachments')
                ->where('is_hidden', 1)
                ->orderBy('created_at', 'asc')
                ->get();
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
