<?php

namespace App\Forums;

use App\Forums\Collections\ReplyList;
use App\Forums\Collections\ReplyEdit;
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
    	return $this->belongsTo(\App\User::class);
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

    public function activeByThreadId($threadId)
    {
        $replyList = new ReplyList();

        $replies = $this->with('user', 'attachments')
                    ->where('thread_id', $threadId)
                    ->where('is_hidden', 0)
                    ->latest()
                    ->get();

        return $replyList->reply($replies);
    }

    public function edit($id)
    {
        $replyList = new ReplyEdit();

        $reply = $this->with('user', 'attachments')->find($id);

        return $replyList->reply($reply);
    }

    public function updateOrCreate($request)
    {
        $replyList = new ReplyList();

        if($request->has('id')) {
            $reply = $this->find($request->id);
            $reply->update($this->setDataArray($request));
            return $replyList->reply($reply);
        } 
        return $replyList->reply($this->create($this->setDataArray($request)));
    }

    public function hidden() 
    {
        return $this->with('user', 'attachments', 'thread')
                ->where('is_hidden', 1)
                ->orderBy('created_at', 'asc')
                ->get();
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
