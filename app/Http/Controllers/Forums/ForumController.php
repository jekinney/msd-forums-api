<?php

namespace App\Http\Controllers\Forums;

use App\Forums\Reply;
use App\Forums\Thread;
use App\Forums\Channel;
use Illuminate\Http\Request;
use App\Collections\Pagination;
use App\Fractal\HiddenReplies;
use App\Forums\Collections\ChannelList;
use App\Forums\Collections\ThreadList;
use App\Http\Controllers\Controller;

class ForumController extends Controller
{
    protected $thread;

    protected $channel;

    function __construct(Thread $thread, Channel $channel)
    {
        $this->thread = $thread;
        $this->channel = $channel;
    }
    public function index($categoryId, ThreadList $threadList, Pagination $pagination, ChannelList $channelList)
    {
        $threads = $this->thread->activeByCategoryId($categoryId);
        $channels = $this->channel->activeByCategoryId($categoryId);

    	return response()->json([
            'threads' =>  $threadList->reply($threads), 
            'threadsPagination' => $pagination->reply($threads), 
            'channels' => $channelList->reply($channels)
        ]);
    }

    public function hidden() 
    {
    	$threads = fractal(Thread::with('channel')->withCount('replies')->where('is_hidden', true)->latest()->paginate(10), new Threads);
    	$replies = fractal(Reply::with('thread', 'thread.channel', 'thread.channel.category')->where('is_hidden', true)->latest()->paginate(10), new HiddenReplies);

    	return response()->json(['threads' => $threads, 'replies' => $replies]);
    }
}
