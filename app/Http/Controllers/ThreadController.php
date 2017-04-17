<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Fractal\Threads;
use Illuminate\Http\Request;
use App\Http\Requests\Forums\ThreadForm;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Thread $thread)
    {
        return fractal($thread->newstActive(), new Threads)
                ->respond();
    }

       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hidden(Thread $thread)
    {
        return fractal($thread->hidden(), new Threads)->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Forum\ThreadForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadForm $request, Thread $thread)
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
    public function show($slug, Thread $thread)
    {
        return fractal($thread->with('replies')->where('slug', $slug)->first(), new Threads)->parseIncludes('replies')->respond();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
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

        return fractal($thread->fresh(), new Threads)->respond();
    }
}
