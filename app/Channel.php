<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{	
	/**
	 * Fillable fields for mass assignment
	 */
    protected $fillable = ['slug', 'name', 'is_hidden', 'order'];

    /**
     * Cast table column to a type
     */
    protected $casts = ['is_hidden' => 'boolean'];

    /**
    * Get all channels threads
    */
    public function threads()
    {
    	return $this->hasMany(Thread::class);
    }

    public function replies()
    {
        return $this->hasManyThrough(Reply::class, Thread::class);
    }

    public function updateOrCreate($request)
    {
        if($request->has('id')) {
            return $this->find($request->id)->update($this->setDataArray($request));
        }

        return $this->create($this->setDataArray($request));
    }

    protected function setDataArray($request)
    {
        return [
            'slug' => str_slug($request->slug),
            'name' => $request->name,
            'order' => $request->order
        ];
    }
}
