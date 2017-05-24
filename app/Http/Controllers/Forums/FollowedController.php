<?php

namespace App\Http\Controllers\Forums;

use App\Forums\Thread;
use App\Forums\Channel;
use App\Forums\Followed;
use Illuminate\Http\Request;
use App\Collections\UserData;
use App\Http\Controllers\Controller;
use App\Forums\Collections\ThreadList;
use App\Forums\Collections\ChannelDetails;

class FollowedController extends Controller
{
	   protected $followed;

	   function __construct(Followed $followed)
	   {
		      $this->followed = $followed;
	   }

    public function index($userId, ThreadList $threadList, ChannelDetails $channelDetails)
    {
  		  $followeds = $this->followed->with('followable')->where('user_id', $userId)->get();
        $threads = [];
        $channels = []; 

  		  foreach($followeds as $followed) {
  			   $type = strtolower(class_basename($followed->followable));
  			   if($type == 'thread') {
  				    $threads[] = $threadList->reply($followed->followable->load('user', 'channel'));
  			   } elseif($type == 'channel') {
  				    $channels[] = $channelDetails->reply($followed->followable->load('category', 'threads'));
  			   }
  		  }

  		  return response()->json(['threads' => $threads, 'channels' => $channels]);
    }

    public function thread(Request $request, Thread $thread, UserData $userData)
    {
    	 $user = $this->followed->toggle($thread->with('followed')->find($request->thread_id), $request->user_id);

    	  return response()->json($userData->reply($user->load('followed')));
    }

    public function channel(Request $request, Channel $channel, UserData $userData)
    {
    	   $user = $this->followed->toggle($channel->with('followed')->find($request->channel_id), $request->user_id);

    	   return response()->json($userData->reply($user->load('followed')));
    }
}
