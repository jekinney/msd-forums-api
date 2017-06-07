<?php

namespace App\Http\Controllers\Notifications;

use Carbon\Carbon;

use Nexmo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class NexmoController extends Controller
{
    public function inGoing(Request $request)
    {
        Log::info(json_encode($request->all()));

        return response([], 200);
    }

    public function outGoing(Request $request)
    {
        Log::info(json_encode($request->all()));

        return response([], 200);
    }

    public function confirmation(Request $request)
    {
        Log::info(json_encode($request->all()));
    }

    public function testing()
    {
        return response(Carbon::now()->toRssString());
    }
}
