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
                    ->orderBy('created_at', 'asc')
                    ->get();

        return $replyList->reply($replies);
    }

    public function edit($id)
    {
        $replyList = new ReplyEdit();

        $reply = $this->with('thread')->find($id);

        return $replyList->reply($reply);
    }

    public function submit($request)
    {
        return $this->create($this->setDataArray($request));
    }

    public function edited($request)
    {
        $replyEdit = new ReplyEdit();

        $reply = $this->find($request->id);
        $reply->update(['reply' => $request->reply]);

        return $replyEdit->reply($reply);
    }

    public function remove($id) 
    {
        $reply = $this->find($id);
        $threadId = $reply->thread_id;
        $reply->delete();

        return $this->activeByThreadId($threadId);
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
