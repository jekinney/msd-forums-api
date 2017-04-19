<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Fractal\Replies;
use App\Fractal\Threads;
use App\Fractal\ReplyDetails;
use Illuminate\Http\Request;
use App\Http\Requests\Forums\ReplyForm;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hidden(Reply $reply)
    {
        return fractal($reply->hidden(), new Replies)->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Request\Forums\ReplyForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReplyForm $request, Reply $reply)
    {
        $reply = $reply->updateOrCreate($request);

        return fractal(
            Thread::with('channel', 'replies', 'user', 'replies.user')
            ->withCount('replies')
            ->find($reply->thread_id), new Threads)
            ->parseIncludes(['channel', 'replies'])
            ->respond();
    }

    public function edit($id, Reply $reply)
    {
        return fractal($reply->find($id), new ReplyDetails)->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Reply $reply)
    {
        $reply = $reply->find($id);
        $reply->is_hidden = $reply->is_hidden? false:true;
        $reply->save();

        return fractal($reply, new Replies)->respond();
    }
}
