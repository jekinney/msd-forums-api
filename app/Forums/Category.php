<?php

namespace App\Forums;

use Illuminate\Database\Eloquent\Model;
use App\Forums\Collections\CategoryShow;
use App\Forums\Collections\CategoryDetails;

class Category extends Model
{
    /**
	 * Fillable fields for mass assignment
	 */
    protected $fillable = ['slug', 'name', 'is_hidden', 'order'];


    public function channels() 
    {
    	return $this->hasMany(Channel::class)->orderBy('order', 'asc');
    }

    public function threads()
    {
        return $this->hasManyThrough(Thread::class, Channel::class)->latest();
    }

    /**
     * Functions
     */
    public function findByIdForShow($id)
    {
        $category = new CategoryShow();

        return $category->reply($this->with('channels', 'threads')->find($id));
    }
    public function updateOrCreate($request)
    {
        if($request->has('id')) {
            $this->find($request->id)->update($this->setDataArray($request));
        } else {
            $this->create($this->setDataArray($request));
        }

        return $this->getAll();
    }

    public function active()
    {
        return $this->where('is_hidden', 0)->orderBy('order', 'asc')->get();
    }

    public function getAll()
    {
        $catDetails = new CategoryDetails();

        $categories = $this->with('channels.threads', 'channels.threads.replies')
                ->withCount('channels')
                ->get();

        return $catDetails->reply($categories);
    }

    public function toggleHidden($id)
    {
        $category = $this->find($id);
        $category->is_hidden = $category->is_hidden? false:true;
        $category->save();

        return $this->getAll();
    }

    protected function setDataArray($request)
    {
        return [
            'slug' => str_slug($request->slug),
            'name' => $request->name,
            'order' => $request->order,
        ];
    }
}
