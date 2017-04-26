<?php

namespace App\Http\Controllers\Notifications;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\Notification;
use App\Http\Controllers\Controller;
use App\Events\Notifications\ProcessNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Notification $notification)
    {
        $notifications = $notification->get();

        return response()->json([
            'upcoming' => $notifications->where('send_at', '>', Carbon::now()),
            'past' => $notifications->where('send_at', '<=', Carbon::now())
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Notification $notification)
    {
        $notification = $notification->updateOrCreate($request);

        if($request->has('send_now') && $request->send_now) {
            event(new ProcessNotification($notification, $request));
        }

        return response(['success' => 'processing'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notifications\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show($id, Notification $notification)
    {
        return $notification->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notifications\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notifications\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notifications\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
