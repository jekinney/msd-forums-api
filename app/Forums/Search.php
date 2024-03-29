<?php

namespace App\Forums;

use App\Forums\Thread;
use App\Forums\Channel;
use App\Forums\Category;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    public function find($request)
    {
    	$categories = Category::where('name', 'LIKE', '%'.$request->search.'%')->get();
    	$channels = Channel::where('name', 'LIKE', '%'.$request->search.'%')->get();
    	$threads = Thread::where('title', 'LIKE', '%'.$request->search)->where('body', 'LIKE', '%'.$request->search.'%')->get();

    	return collect(['categories' => $categories, 'channels' => $channels, 'threads' => $threads]);
    }
}
