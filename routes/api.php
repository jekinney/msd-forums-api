<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v1/forums'], function() {

	Route::get('/forum/setup', 'ForumController@index');

	Route::get('/categories/active', 'CategoryController@index');
	Route::get('categories/hidden', 'CategoryController@hidden');
	Route::get('/category/{id}', 'CategoryController@show');
	Route::post('/category/store', 'CategoryController@store');
	Route::delete('/category/{id}', 'CategoryController@destroy');

	Route::get('channels', 'ChannelController@index');
	Route::get('channel/{id}', 'ChannelController@show');
	Route::post('/channel', 'ChannelController@store');
	Route::put('/channel/{channel}', 'ChannelController@update');
	Route::delete('/channel/{channel}', 'ChannelController@destroy');

	Route::get('/threads/newest', 'ThreadController@newest');
	Route::get('/threads', 'ThreadController@index');
	Route::get('/thread/{thread}', 'ThreadController@show');
	Route::post('/thread', 'ThreadController@store');
	Route::put('/thread/{thread}', 'ThreadController@update');
	Route::delete('/thread/{thread}', 'ThreadController@destroy');


	Route::post('/reply', 'ReplyController@store');
	Route::put('/reply', 'ReplyController@update');
	Route::post('/reply', 'ReplyController@store');
	Route::put('/reply/{reply}', 'ReplyController@update');
	Route::delete('/reply/{reply}', 'ReplyController@destroy');

	
});
