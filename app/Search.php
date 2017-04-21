<?php

namespace App;

use App\Thread;
use App\Channel;
use App\Catagory;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    public function find($request)
    {
    	$catagories = Catagory::where('name', 'LIKE', '%'.$request->search.'%')->get();
    	$channels = Channel::where('name', 'LIKE', '%'.$request->search.'%')->get();
    	$threads = Threads::where('title', 'LIKE', '%'.$request->search)->where('body', 'LIKE', '%'.$request->search.'%')->get();

    	return collect(['catagories' => $catagories, 'channels' => $channels, 'threads' => $threads]);
    }
}
