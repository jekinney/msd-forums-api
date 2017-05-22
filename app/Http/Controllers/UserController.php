<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Collections\UserData;

class UserController extends Controller
{
    protected $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UserData $userData)
    {       
        return response()->json($userData->reply($this->user->updateOrCreate($request)->load('followed')));
    }
}
