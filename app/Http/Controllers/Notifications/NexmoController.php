<?php

namespace App\Http\Controllers;

use App\Notifications\InboundText;
use Illuminate\Http\Request;

class NexmoController extends Controller
{
    public function incoming(Request $request)
    {
        return $request->all();
    }
}
