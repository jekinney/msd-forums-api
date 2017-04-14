<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use App\Category;
use App\Fractal\Threads;
use App\Fractal\Channels;
use App\Fractal\Categories;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index(Category $category)
    {
    	$threads = fractal(Thread::with('channel')->withCount('replies')->latest()->paginate(10), new Threads);
    	$channels = fractal(Channel::get(), new Channels);

    	return response()->json(collect(['threads' => $threads, 'channels' => $channels]));
    }
}
