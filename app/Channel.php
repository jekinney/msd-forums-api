<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = ['slug', 'name', 'hidden'];

    public function threads()
    {
    	return $this->belongsToMany(Thread::class);
    }
}
