<?php

namespace App\Http\Controllers\Forums;

use App\Forums\Reply;
use App\Forums\Thread;
use App\Forums\Attachment;
use Illuminate\Http\Request;
use App\Collections\Pagination;
use App\Forums\Collections\ThreadList;
use App\Forums\Collections\ReplyList;
use App\Forums\Fractal\Threads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Forums\ThreadForm;

class ThreadController extends Controller
{
    protected $thread;

    protected $reply;

    function __construct(Thread $thread, Reply $reply)
    {
        $this->thread = $thread;
        $this->reply = $reply;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryId, ThreadList $threadList)
    {
        return response()->json([
            'threads' => $threadList->reply($this->thread->newestActive($categoryId))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Forum\ThreadForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadForm $request, ThreadList $threadList)
    {
        $thread = $this->thread->addOrUpdate($request);

        return response()->json(['thread' => $thread->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($id, ThreadList $threadList, ReplyList $replyList, Pagination $pagination)
    {
        $replies = $this->reply->activeByThreadId($id);

        return response()->json([
            'thread' => $threadList->reply($this->thread->with('user', 'attachments')->find($id)), 
            'replies' => $replyList->reply($replies),
            'repliesPagination' => $pagination->reply($replies)
        ]);
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
         return response()->json(['thread' => $this->thread->with('attachments')->find($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ThreadList $threadList)
    {
        $thread = $this->thread->find($request->id);
        $thread->is_hidden = $thread->is_hidden? false:true;
        $thread->save();

        if($request->has('hidden')) {
            $threads = $this->thread->hidden();
        } elseif($request->has('channel_id')) {
            $threads = $this->thread->activeByChannelId($request->channel_id);
        } elseif($request->has('category_id')) {
            $threads = $this->thread->activeByCategoryId($request->category_id);
        } else {
            return response()->json([], 200);
        }

        return response()->json(['threads' => $threadList->reply($threads)]);;
    }
}
