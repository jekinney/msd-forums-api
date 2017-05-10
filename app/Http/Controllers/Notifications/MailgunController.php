<?php

namespace App\Http\Controllers\Notifications;

use Illuminate\Support\Facades\Log;
use App\Notifications\Recipient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MailgunController extends Controller
{
	protected $recipient;

	function __construct(Recipient $recipient) 
	{
		$this->recipient = $recipient;
	}

	public function delievered(Request $request)
	{
		Log::info($request->all());
	}

	public function dropped(Request $request)
	{
		Log::info($request->all());
	}

	public function bounced(Request $request)
	{
		Log::info($request->all());
	}

	public function opens(Request $request)
	{
		Log::info($request->all());
	}
}