<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Fractal\Replies;
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
        return fractal($reply->updateOrCreate($request), new Replies)->respond();
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
