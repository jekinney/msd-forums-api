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
    	$categories =fractal($category->active(), new Categories);
    	$threads = fractal(Thread::with('category')->withCount('replies')->latest()->limit(20)->get(), new Threads);
    	$channels = fractal(Channel::get(), new Channels);

    	return response()->json(collect(['categories' => $categories, 'threads' => $threads, 'channels' => $channels]));
    }
}
