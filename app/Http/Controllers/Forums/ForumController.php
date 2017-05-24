<?php

namespace App\Http\Controllers\Forums;

use App\Forums\Reply;
use App\Forums\Thread;
use App\Forums\Channel;
use Illuminate\Http\Request;
use App\Collections\Pagination;
use App\Http\Controllers\Controller;
use App\Forums\Collections\ReplyList;
use App\Forums\Collections\ThreadList;
use App\Forums\Collections\ChannelList;

class ForumController extends Controller
{
    protected $thread;

    protected $channel;

    protected $reply;

    function __construct(Thread $thread, Channel $channel, Reply $reply)
    {
        $this->thread = $thread;
        $this->channel = $channel;
        $this->reply = $reply;
    }

    public function index($categoryId, ChannelList $channelList)
    {
        $channels = $this->channel->activeByCategoryId($categoryId);

    	return response()->json(['channels' => $channelList->reply($channels)]);
    }

    public function hidden(ThreadList $threadList, ReplyList $replyList) 
    {
        $threads = $this->thread->hidden();
        $replies = $this->reply->hidden();

        return response()->json([
            'threads' => $threadList->reply($threads), 
            'replies' => $replyList->reply($replies)
        ]);
    }
}
