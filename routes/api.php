<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v1/forums'], function() {

	Route::get('/forum/setup', 'ForumController@index');
	Route::get('/forum/hidden', 'ForumController@hidden');

	Route::post('/user', 'UserController@store');

	Route::get('channels', 'ChannelController@index');
	Route::get('channels/all', 'ChannelController@all');
	Route::get('channel/{id}', 'ChannelController@show');
	Route::post('/channel', 'ChannelController@store');
	Route::delete('/channel/{id}', 'ChannelController@destroy');

	Route::get('/threads', 'ThreadController@index');
	Route::get('/thread/{id}', 'ThreadController@show');
	Route::get('/thread/{id}/edit', 'ThreadController@edit');
	Route::post('/thread', 'ThreadController@store');
	Route::put('/thread/{id}', 'ThreadController@update');
	Route::delete('/thread/{id}', 'ThreadController@destroy');

	Route::get('/reply', 'ReplyController@edit');
	Route::post('/reply', 'ReplyController@store');
	Route::put('/reply/{id}', 'ReplyController@update');
	Route::delete('/reply/{id}', 'ReplyController@destroy');

	Route::get('/attachments', 'AttachmentController@index');
	Route::post('/attachment/image', 'AttachmentController@storeImage');
	Route::post('/attachment/files', 'AttachmentController@storeIFiles');
	Route::delete('/attachment/{id}', 'AttachmentController@destroy');
});
