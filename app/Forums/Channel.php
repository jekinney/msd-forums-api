<?php

namespace App\Forums;

use App\Forums\Collections\ChannelList;
use Illuminate\Database\Eloquent\Model;
use App\Forums\Collections\ChannelShow;
use App\Forums\Collections\ChannelDetails;

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
    	return $this->hasMany(Thread::class)->latest();
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

    public function findByIdForShow($id)
    {
        $channel = new ChannelShow();

        return $channel->reply($this->with('threads')->find($id));
    }

    public function updateOrCreate($request)
    {
        if($request->has('id')) {
            $this->find($request->id)->update($this->setDataArray($request));
        } else {
            $this->create($this->setDataArray($request));
        }
        
        return $this->getAllWithDetails();
    }

    public function menuList($categoryId)
    {
        $channelList = new ChannelList();

        $channels = $this->where('category_id', $categoryId)
                ->where('is_hidden', 0)
                ->orderBy('order', 'asc')
                ->get();

        return $channelList->reply($channels);
    }

    public function getAllWithDetails()
    {
        $channelDetails = new ChannelDetails();
        
        $channels = $this->with('category', 'threads.replies')->withCount('threads')->get();

        return $channelDetails->reply($channels);
    }

    public function findById($id)
    {
        $channelDetails = new ChannelDetails();

        return $channelDetails->reply($this->with('category', 'threads.replies')->withCount('threads')->find($id));
    }

    public function toggleHidden($id)
    {
        $channel = $this->find($id);
        $channel->is_hidden = $channel->is_hidden? false:true;
        $channel->save();

        return $this->getAllWithDetails();
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
