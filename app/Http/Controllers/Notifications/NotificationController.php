<?php

namespace App\Http\Controllers\Notifications;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\Notification;
use App\Http\Controllers\Controller;
use App\Events\Notifications\ProcessNotification;
use App\Events\Notifications\SendTestNotification;
use App\Notifications\Collections\Notifications;
use App\Notifications\Collections\Recipients;
use App\Notifications\Collections\PastNotifications;
use App\Notifications\Collections\UpcomingNotifications;

class NotificationController extends Controller
{
    protected $notification;

    function __construct(Notification $notification) 
    {
        $this->notification = $notification;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PastNotifications $past, UpcomingNotifications $upcoming)
    {
        return response()->json([
            'past' => $past->reply($this->notification->past()),
            'upcoming' => $upcoming->reply($this->notification->upcoming()),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function past(PastNotifications $past)
    {
        return response()->json($past->reply($this->$notification->past()));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upcoming(UpcomingNotifications $upcoming)
    {
        return response()->json($upcoming->reply($this->notification->upcoming()));
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
    public function store(Request $request)
    {   
        $notification = $this->notification->updateOrCreate($request);

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
    public function show($id, Notifications $notifications, Recipients $recipients)
    {
        $notification = $this->notification->with('recipients')->find($id);

        return response()->json([
            'notification' => $notifications->reply($notification), 
            'recipients' => $recipients->reply($notification->recipients)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notifications\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->notification->remove($id);

        return response()->json([], 200);
    }
}
