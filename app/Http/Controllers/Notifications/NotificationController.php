<?php

namespace App\Http\Controllers\Notifications;

use Illuminate\Http\Request;
use App\Notifications\Notification;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Notification $notification)
    {
        return $notification->get();
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
        $notification->updateOrCreate($request);
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