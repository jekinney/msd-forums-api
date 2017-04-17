<?php

namespace App\Http\Controllers;

use App\Reported;
use Illuminate\Http\Request;

class ReportedController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Reported $reported)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string $type
     * @param  \App\Reported  $reported
     * @return \Illuminate\Http\Response
     */
    public function show($type, Reported $reported)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reported  $reported
     * @return \Illuminate\Http\Response
     */
    public function edit(Reported $reported)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reported  $reported
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reported $reported)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reported  $reported
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reported $reported)
    {
        //
    }
}
