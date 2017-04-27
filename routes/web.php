<?php

use App\Notifications\Notification;
use App\Mail\Notifications\Basic;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function() {
	 Mail::to('jkinney@MSDist.com')->send(new Basic(Notification::find(16)));
});
