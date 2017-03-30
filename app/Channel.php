<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = ['slug', 'name', 'is_hidden'];

    protected $casts = ['is_hidden' => 'boolean'];

    public function threads()
    {
    	return $this->belongsToMany(Thread::class);
    }
}
