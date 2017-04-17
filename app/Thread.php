<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['user_id', 'channel_id', 'slug', 'title', 'body', 'is_hidden', 'reports'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function channel()
    {
    	return $this->belongsTo(Channel::class);
    }

    public function replies()
    {
    	return $this->hasMany(Reply::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function hidden() 
    {
        return $this->where('is_hidden', 1)->get();
    }

    public function newestActive($amount = 10)
    {
        return $this->with('channel')->withCount('replies')->where('is_hidden', 0)->latest()->paginate($amount);
    }

    public function addOrUpdate($request)
    {
        if($request->has('id')) {
            $thread = $this->find($request->id);
            $thread->update($this->dataArray($request));
            return $thread;
        } 
        return $this->create($this->dataArray($request));
    }

    public function dataArray($request)
    {
        return [
            'channel_id' => $request->channel_id,
            'user_id' => 1,
            'slug' => str_slug($request->title),
            'title' => $request->title,
            'body' => $request->body,
        ];
    }
}
