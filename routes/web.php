<?php

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

// Route::get('/nexmo/send', function() {
// 	 $request = Nexmo::message()->send([
//             'to' => '13609290280',
//             'from' => env('NEXMO_PHONE'),
//             'text' => 'test response'
//         ]);
// 	dd($request->getResponseData()['messages'][0]);
// });
