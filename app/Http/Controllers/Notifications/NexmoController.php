<?php

namespace App\Http\Controllers\Notifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NexmoController extends Controller
{
    public function inGoing(Request $request)
    {
        return response([], 200);
    }

    public function outGoing()
    {
        return response([], 200);
    }
}
