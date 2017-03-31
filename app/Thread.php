<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['user_id', 'category_id', 'slug', 'title', 'body', 'hidden', 'reports'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }

    public function channels()
    {
    	return $this->belongsToMany(Channel::class);
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
        return $this->where('hidden', 1)->get();
    }
}
