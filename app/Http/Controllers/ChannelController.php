<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Fractal\Channels;
use App\Fractal\ChannelDetails;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryId, Channel $channel)
    {
        return fractal($channel->where('is_hidden', 0)->where('category_id', $categoryId)->orderBy('order', 'asc')->get(), new Channels)->respond();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Channel $channel)
    {
        return fractal($channel->with('category')->withCount('threads', 'replies')->orderBy('order', 'asc')->get(), new ChannelDetails)->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Channel $channel)
    {
        $channel->updateOrCreate($request);

        return fractal($channel->with('category')->withCount('threads', 'replies')->orderBy('order', 'asc')->get(), new ChannelDetails)->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function show($id, Channel $channel)
    {
        $channel = $channel->with(['threads' => function($q) { $q->orderBy('created_at', 'desc'); }])->find($id);

        return fractal($channel, new Channels)->parseIncludes('threads')->respond();
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
