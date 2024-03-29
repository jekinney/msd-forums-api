<?php

namespace App\Http\Controllers\Forums;

use App\Forums\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    public function index()
    {
        return response()->json($this->channel->getAllWithDetails());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json($this->channel->updateOrCreate($request));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->channel->findByIdForShow($id));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json($this->channel->toggleHidden($id));
    }
}
