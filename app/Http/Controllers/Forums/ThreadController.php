<?php

namespace App\Http\Controllers\Forums;

use App\Forums\Thread;
use App\Forums\Attachment;
use Illuminate\Http\Request;
use App\Forums\Fractal\Threads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Forums\ThreadForm;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryId, Thread $thread)
    {
        return fractal($thread->newestActive($categoryId), new Threads)->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Forum\ThreadForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadForm $request, Thread $thread, Attachment $attachment)
    {
        $thread = $thread->addOrUpdate($request);

        return fractal($thread->fresh(), new Threads)->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($id, Thread $thread)
    {
        return fractal($thread->show($id), new Threads)
            ->parseIncludes(['channel', 'replies', 'attachments'])
            ->respond();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Thread $thread)
    {
         return fractal($thread->with('attachments')->find($id), new Threads)->parseIncludes(['attachments'])->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Thread $thread)
    {
        $thread = $thread->find($id);
        $thread->is_hidden = $thread->is_hidden? false:true;
        $thread->save();

        return response()->json(['hidden' => $thread->is_hidden]);;
    }
}