<?php

namespace App\Http\Controllers\Forums;

use App\Forums\Thread;
use Illuminate\Http\Request;
use App\Forums\Collections\ThreadList;
use App\Http\Controllers\Controller;
use App\Http\Requests\Forums\ThreadForm;

class ThreadController extends Controller
{
    protected $thread;

    function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryId)
    {
        return response()->json($this->thread->activeByCategoryId($categoryId));
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $categoryId
     * @return \Illuminate\Http\Response
     */
    public function category($categoryId)
    {
        return response()->json($this->thread->categoryId($categoryId));
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $channelId
     * @return \Illuminate\Http\Response
     */
    public function channel($channelId)
    {
        return response()->json($this->thread->channelId($channelId));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hidden()
    {
        return response()->json($this->thread->hidden());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Forum\ThreadForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadForm $request)
    {
        return response()->json($this->thread->addOrUpdate($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->thread->show($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         return response()->json($this->thread->edit($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return response()->json($this->thread->toggleHidden($request->id));
    }
}
