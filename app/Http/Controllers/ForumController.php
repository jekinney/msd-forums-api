<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Channel;
use App\Fractal\Threads;
use App\Fractal\Channels;
use Illuminate\Http\Request;
use App\Fractal\HiddenReplies;

class ForumController extends Controller
{
    public function index($categoryId)
    {
    	$threads = fractal(
            Thread::whereHas('channel', function($q) use($categoryId) {
                $q->where('is_hidden', 0);
                $q->where('category_id', $categoryId);
            })->withCount('replies')
            ->latest()
            ->paginate(10), 
            new Threads
        );

    	$channels = fractal(
            Channel::where('is_hidden', false)
            ->where('category_id', $categoryId)
            ->orderBy('order', 'asc')
            ->get(), 
            new Channels
        );

    	return response()->json(collect(['threads' => $threads, 'channels' => $channels]));
    }

    public function hidden() 
    {
    	$threads = fractal(Thread::with('channel')->withCount('replies')->where('is_hidden', true)->latest()->paginate(10), new Threads);
    	$replies = fractal(Reply::where('is_hidden', true)->latest()->paginate(10), new HiddenReplies);

    	return response()->json(collect(['threads' => $threads, 'replies' => $replies]));
    }
}
