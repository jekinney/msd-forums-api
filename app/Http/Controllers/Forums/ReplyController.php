<?php

namespace App\Http\Controllers\Forums;

use App\Forums\Reply;
use App\Forums\Thread;
use Illuminate\Http\Request;
use App\Forums\Fractal\Replies;
use App\Forums\Fractal\Threads;
use App\Forums\Fractal\ReplyDetails;
use App\Http\Controllers\Controller;
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

        return fractal($reply->load('attachments'), new ReplyDetails)->respond();
    }

    public function edit($id, Reply $reply)
    {
        return fractal($reply->with('attachments')->find($id), new ReplyDetails)->respond();
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

        return response()->json(['hidden' => $reply->is_hidden]);
    }
}
