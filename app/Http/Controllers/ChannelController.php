<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Fractal\Channels;
use App\Fractal\AllChannels;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel)
    {
        return fractal($channel->where('is_hidden', 0)->orderBy('order', 'asc')->get(), new Channels)->respond();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Channel $channel)
    {
        return fractal($channel->withCount('threads', 'replies')->orderBy('order', 'asc')->get(), new AllChannels)->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Channel $channel)
    {
        if($request->has('id')) {
            $channel = $channel->find($request->id)
        }
        $channel->create([
                'slug' => str_slug($request->name),
                'name' => $request->name,
                'order' => $request->order
            ]);

        return fractal($channel->withCount('threads', 'replies')->orderBy('order', 'asc')->get(), new AllChannels)->respond();
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
        $channel = $channel->with('threads')->find($id);

        return fractal($channel, new Channels)->parseIncludes('threads')->respond();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Channel $channel)
    {
        return fractal($channel->find($id), new Channels)->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Channel $channel)
    {
        $channel = $channel->find($request->id);
        $channel->update([
            'slug' => str_slug($request->name),
            'name' => $request->name,
            'order' => $request->order,
            'is_hidden' => $request->is_hidden
        ]);

        return response()->json([], 200);
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

        return response()->json([], 200);
    }
}
