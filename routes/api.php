<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v1/forums'], function() {

	Route::get('/forum/setup', 'ForumController@index');
	Route::get('/forum/hidden', 'ForumController@hidden');

	Route::get('channels', 'ChannelController@index');
	Route::get('channels/all', 'ChannelController@all');
	Route::get('channel/create', 'ChannelController@create');
	Route::get('channel/{id}', 'ChannelController@show');
	Route::get('channel/{id}/edit', 'ChannelController@edit');
	Route::post('/channel', 'ChannelController@store');
	Route::put('/channel/', 'ChannelController@update');
	Route::delete('/channel/{id}', 'ChannelController@destroy');

	Route::get('/threads/newest', 'ThreadController@newest');
	Route::get('/threads/hidden', 'ThreadController@hidden');
	Route::get('/threads', 'ThreadController@index');
	Route::get('/thread/{slug}', 'ThreadController@show');
	Route::get('/thread/{slug}/edit', 'ThreadController@edit');
	Route::post('/thread', 'ThreadController@store');
	Route::put('/thread/{thread}', 'ThreadController@update');
	Route::delete('/thread/{id}', 'ThreadController@destroy');


	Route::get('/replies/hidden', 'ReplyController@hidden');
	Route::get('/reply', 'ReplyController@edit');
	Route::post('/reply', 'ReplyController@store');
	Route::put('/reply/{id}', 'ReplyController@update');
	Route::delete('/reply/{id}', 'ReplyController@destroy');

	Route::get('/attachments', 'AttachmentController@index');
	Route::post('/attachment', 'AttachmentController@store');
	Route::delete('/attachment/{attachment}', 'AttachmentController@destroy');
});
