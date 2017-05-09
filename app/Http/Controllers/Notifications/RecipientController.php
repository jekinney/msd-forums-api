<?php

namespace App\Http\Controllers\Notifications;

use Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecipientController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $uploads = Excel::load($request->file('contacts'))->toArray();
        $recipients = [];

        foreach($uploads as $upload) {
            $recipients[] = array_only($upload, ['name', 'email', 'phone']);
        }

        return response()->json($recipients);
    }
}
