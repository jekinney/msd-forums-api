<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
    	'slug', 'name', 'description', 'description_hidden', 'is_hidden', 'display_order',
    ];

    protected $casts = ['is_hidden' => 'boolean'];

    public function threads()
    {
    	return $this->hasMany(Thread::class);
    }

    public function active()
    {
    	return $this->where('is_hidden', false)->orderBy('display_order', 'asc')->get();
    }

    public function hidden() 
    {
    	return $this->where('is_hidden', true)->orderBy('display_order', 'asc')->get();
    }

    public function addOrUpdate($request)
    {
    	if($request->has('id')) {
    		$this->find($request->id)->update($this->dataArray($request));
    	} else {
    		$this->create($this->dataArray($request));
    	}

    	return '200';
    }

    public function toggleHidden($id)
    {
    	$category = $this->find($id);
        $category->is_hidden = $category->is_hidden? false:true;
    	return $category->save();
    }

    protected function dataArray($request)
    {
    	return [
    		'slug' => str_slug($request->name),
			'name' => $request->name,
			'description' => $request->description,
			'hide_description' => $request->has('hide_description')? false:false,
			'is_hidden' => $request->hidden,
			'display_order' => $request->has('display_order')? $request->display_order:$this->count() + 1,
    	];
    }
}
