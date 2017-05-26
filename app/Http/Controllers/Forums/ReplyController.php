<?php

namespace App\Http\Controllers\Forums;

use App\Forums\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Forums\ReplyForm;


class ReplyController extends Controller
{
    protected $reply;

    function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    public function index($threadId) 
    {
        return response()->json($this->reply->activeByThreadId($threadId));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hidden()
    {
        return response()->json($reply->hidden());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Request\Forums\ReplyForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReplyForm $request, Reply $reply)
    {
        return response()->json($reply->submit($request));
    }

    public function edit($id)
    {
        return response()->json($this->reply->edit($id));
    }

    public function update(Request $request)
    {
        return response()->json($this->reply->edited($request));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reply = $this->reply->find($id);
        $reply->is_hidden = $reply->is_hidden? false:true;
        $reply->save();

        return response()->json($reply);
    }
}
