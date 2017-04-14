<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v1/forums'], function() {

	Route::get('/forum/setup', 'ForumController@index');

	Route::get('channels', 'ChannelController@index');
	Route::get('channel/{id}', 'ChannelController@show');
	Route::post('/channel', 'ChannelController@store');
	Route::put('/channel/{channel}', 'ChannelController@update');
	Route::delete('/channel/{channel}', 'ChannelController@destroy');

	Route::get('/threads/newest', 'ThreadController@newest');
	Route::get('/threads/hidden', 'ThreadController@hidden');
	Route::get('/threads', 'ThreadController@index');
	Route::get('/thread/{slug}', 'ThreadController@show');
	Route::post('/thread', 'ThreadController@store');
	Route::put('/thread/{thread}', 'ThreadController@update');
	Route::delete('/thread/{id}', 'ThreadController@destroy');


	Route::get('/replies/hidden', 'ReplyController@hidden');
	Route::put('/reply', 'ReplyController@update');
	Route::post('/reply', 'ReplyController@store');
	Route::put('/reply/{reply}', 'ReplyController@update');
	Route::delete('/reply/{reply}', 'ReplyController@destroy');

	Route::get('/attachments', 'AttachmentController@index');
	Route::post('/attachment', 'AttachmentController@store');
	Route::delete('/attachment/{attachment}', 'AttachmentController@destroy');
});
