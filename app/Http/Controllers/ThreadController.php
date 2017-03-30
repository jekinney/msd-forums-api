<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Fractal\Threads;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Thread $thread)
    {
        return fractal($thread->with('category')->withCount('replies')->latest()->get(), new Threads)
                ->respond();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newest(Thread $thread)
    {
        return fractal($thread->with('category')->withCount('replies')->latest()->limit(20)->get(), new Threads)
                ->respond();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Thread $thread)
    {
        if($request->has('id')) {
            $thread->find($request->id)->update([
                'category_id' => $request->category_id,
                'channel_id' => $request->channel_id,
                'user_id' => 1,
                'slug' => str_slug($request->title),
                'title' => $request->title,
                'body' => $request->body,
            ]);
        } else {
            $thread->create([
                'category_id' => $request->category_id,
                'channel_id' => $request->channel_id,
                'user_id' => 1,
                'slug' => str_slug($request->title),
                'title' => $request->title,
                'body' => $request->body,
            ]);
        }

        return response()->json('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
        return fractal($thread->load('replies'), new Threads)->parseIncludes('replies')->respond();
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
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
