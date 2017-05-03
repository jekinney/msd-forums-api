<?php

namespace App\Http\Controllers\Forums;

use App\Forums\Channel;
use App\Forums\Thread;
use Illuminate\Http\Request;
use App\Collections\Pagination;
use App\Http\Controllers\Controller;
use App\Forums\Collections\Channels;
use App\Forums\Collections\ThreadList;
use App\Forums\Collections\ChannelDetails;

class ChannelController extends Controller
{
    protected $channel;

    function __construct(Channel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryId)
    {
        return fractal($this->channel->where('is_hidden', 0)->where('category_id', $categoryId)->orderBy('order', 'asc')->get(), new Channels)->respond();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(ChannelDetails $channelDetails)
    {
        $channels = $this->channel->getAllWithDetails();

        return response()->json(['channels' => $channelDetails->reply($channels)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ChannelDetails $channelDetails)
    {
        $channels = $this->channel->updateOrCreate($request);

        return response()->json(['channels' => $channelDetails->reply($channels)]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function show($id, Thread $thread, Pagination $pagination, ThreadList $ThreadList)
    {
        $channel = $this->channel->find($id);
        $threads = $thread->activeByChannelId($id); 

        return response()->json(collect([
            'channel' => $channel, 
            'threads' => $ThreadList->reply($threads), 
            'threadsPagination' => $pagination->reply($threads)
        ]));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Channel $channel)
    {
        $channel = $channel->find($id);
        $channel->is_hidden = $channel->is_hidden? false:true;
        $channel->save();

        return fractal($channel->with('category')->withCount('threads', 'replies')->orderBy('order', 'asc')->get(), new ChannelDetails)->respond();
    }
}
