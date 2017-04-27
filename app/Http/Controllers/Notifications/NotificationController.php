<?php

namespace App\Http\Controllers\Notifications;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\Notification;
use App\Http\Controllers\Controller;
use App\Events\Notifications\ProcessNotification;
use App\Events\Notifications\SendTestNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Notification $notification)
    {
        return response()->json($notification->getAll());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function past(Notification $notification)
    {
        return $notification->past();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upcoming(Notification $notification)
    {
        return $notification->upcoming();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test(Request $request)
    {
        event(new SendTestNotification($request));

        return response()->json([], 200);
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
        return response()->json($notification->with('recipients')->find($id));
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
