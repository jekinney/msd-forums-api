<?php

namespace App\Forums;

use App\Forums\Collections\ThreadList;
use App\Forums\Collections\ThreadShow;
use App\Forums\Collections\ThreadEdit;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
     /**
     * Fillable fields for mass assignment
     */
    protected $fillable = [
        'user_id', 'channel_id',
        'slug', 'title', 'body', 
        'is_hidden', 'reports'
    ];

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
     * Get all of the threads following users.
     */
    public function followed()
    {
        return $this->morphMany(Followed::class, 'followable');
    }

     /**
     * Get all not hidden threads with associated channel
     * and reply count in a paginated list
     *
     * @param int $amount
     * @return collection Thread
     */
    public function categoryId($categoryId, $amount = 10)
    {
        $threadList = new ThreadList();

        $threads = $this->whereHas('channel', function($q) use($categoryId) {
                $q->where('is_hidden', 0);
                $q->where('category_id', $categoryId);
            })->withCount('replies', 'attachments')
            ->with('user')
            ->where('is_hidden', 0)
            ->latest()
            ->get();

        return $threadList->reply($threads);
    }

    public function channelId($channelId, $amount = 10)
    {
        $threadList = new ThreadList();

        return $this->with('user')
                ->withCount('replies', 'attachments')
                ->where('channel_id', $channelId)
                ->where('is_hidden', 0)
                ->latest()
                ->get();

        return $threadList->reply($threads);
    }

    /**
     * Get all hidden threads
     */
    public function hidden() 
    {   
        $threadShow = new ThreadShow();

        $threads = $this->with('channel', 'user', 'attachments')
                ->withCount('replies', 'attachments')
                ->where('is_hidden', 1)
                ->orderBy('created_at', 'asc')
                ->get();

        return $threadShow->reply($threads);
    }

    /**
     * Get a thread to show user 
     */
    public function show($id)
    {
        $threadShow = new ThreadShow();

        $thread = $this->with('channel', 'user', 'attachments')
                ->withCount('replies', 'attachments')
                ->find($id);

        return $threadShow->reply($thread);
    }

    /**
     * Get a thread for editing (minimum data)
     */
    public function edit($id)
    {
        $threadEdit = new ThreadEdit();

        $thread = $this->with('channel', 'attachments')->find($id);

        return $threadEdit->reply($thread);
    }

    public function toggleHidden($id) 
    {
        $threadShow = new ThreadShow();

        $thread = $this->find($id);
        $thread->is_hidden = $thread->is_hidden? false:true;
        $thread->save();

        return $threadShow->reply($thread->fresh());
    }

     /**
     * Insert a thread
     *
     * @param  \Illuminate\Http\Request  $request
     * @return object Thread
     */
    public function submitAdd($request)
    {
        $threadList = new ThreadList();

        $thread = $this->create($this->dataArray($request));
        
        return $threadList->reply($thread->load('channel', 'user', 'attachments'));
    }

     /**
     *update a thread
     *
     * @param  \Illuminate\Http\Request  $request
     * @return object Thread
     */
    public function submitUpdate($request)
    {
        $threadList = new ThreadList();

        $thread = $this->find($request->id);
        $thread->update($this->dataArray($request));
        
        return $threadList->reply($thread->load('channel', 'user', 'attachments'));
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
