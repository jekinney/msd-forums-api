<?php

namespace App\Http\Controllers;

use App\Notifications\InboundText;
use Illuminate\Http\Request;

class NexmoController extends Controller
{
    public function inGoing(Request $request)
    {
        return respond([], 200);
    }

    public function outGoing(Request $request)
    {
        return respond([], 200);
    }
}
