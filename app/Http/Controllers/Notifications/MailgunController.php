<?php

namespace App\Http\Controllers\Notifications;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Notifications\Recipient;
use App\Http\Controllers\Controller;

class MailgunController extends Controller
{
	protected $recipient;

	function __construct(Recipient $recipient) 
	{
		$this->recipient = $recipient;
	}

	public function update(Request $request)
	{
		$this->recipient->updateStatus($request);

		return response()->json([], 200);
	}
}