<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
    	'slug', 'name', 'description', 'description_hidden', 'hidden',
    ];

    public function threads()
    {
    	return $this->hasMany(Thread::class);
    }
}
