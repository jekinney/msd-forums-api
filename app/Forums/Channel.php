<?php

namespace App\Forums;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{	
	/**
	 * Fillable fields for mass assignment
	 */
    protected $fillable = ['category_id', 'slug', 'name', 'is_hidden', 'order'];

    /**
     * Cast table column to a type
     */
    protected $casts = ['is_hidden' => 'boolean'];

    /**
     * Relationships
    *
    * Get channels category
    */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
    * Get all channels threads
    */
    public function threads()
    {
    	return $this->hasMany(Thread::class);
    }

    /**
     * Get all of the threads following users.
     */
    public function followed()
    {
        return $this->morphMany(Followed::class, 'followable');
    }

    /**
    * Get all channels threads
    */
    public function replies()
    {
        return $this->hasManyThrough(Reply::class, Thread::class);
    }

    public function updateOrCreate($request)
    {
        if($request->has('id')) {
            $this->find($request->id)->update($this->setDataArray($request));
        }

        $this->create($this->setDataArray($request));

        return $this->getAllWithDetails();
    }

    public function activeByCategoryId($categoryId)
    {
        return $this->where('category_id', $categoryId)
                ->where('is_hidden', 0)
                ->orderBy('order', 'asc')
                ->get();
    }

    public function getAllWithDetails()
    {
        return $this->with('category', 'threads.replies')->withCount('threads')->get();
    }

    protected function setDataArray($request)
    {
        return [
            'category_id' => $request->category_id,
            'slug' => str_slug($request->slug),
            'name' => $request->name,
            'order' => $request->order
        ];
    }
}
