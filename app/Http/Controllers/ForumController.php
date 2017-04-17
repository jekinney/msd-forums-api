<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Channel;
use App\Fractal\Replies;
use App\Fractal\Threads;
use App\Fractal\Channels;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index()
    {
    	$threads = fractal(Thread::with('channel')->withCount('replies')->latest()->paginate(10), new Threads);
    	$channels = fractal(Channel::where('is_hidden', false)->orderBy('order', 'asc')->get(), new Channels);

    	return response()->json(collect(['threads' => $threads, 'channels' => $channels]));
    }

    public function hidden() 
    {
    	$threads = fractal(Thread::with('channel')->withCount('replies')->where('is_hidden', true)->latest()->paginate(10), new Threads);
    	$replies = fractal(Reply::where('is_hidden', true)->latest()->paginate(10), new Replies);

    	return response()->json(collect(['threads' => $threads, 'replies' => $replies]));
    }
}
