<?php

use Illuminate\Http\Request;


Route::post('v1/user', 'UserController@store');

Route::group(['prefix' => 'v1/notifications', 'namespace' => 'Notifications'], function() {

	Route::get('/text', 'TextsController@index');
	Route::get('/text/{id}/show', 'TextsController@show');
	Route::get('/text/{id}/edit', 'TextsController@edit');
	Route::post('/text', 'TextsController@store');
	Route::post('/text/test', 'TextsController@test');
	Route::patch('text/{id}', 'TextsController@update');
	Route::delete('/text/{id}', 'TextsController@delete');


	Route::get('/email', 'EmailsController@index');
	Route::get('/email/{id}/show', 'EmailsController@show');
	Route::get('/email/{id}/edit', 'EmailsController@edit');
	Route::post('/email', 'EmailsController@store');
	Route::post('/email/test', 'EmailsController@test');
	Route::patch('email/{id}', 'EmailsController@update');
	Route::delete('/email/{id}', 'EmailsController@delete');

	Route::get('/recipients', 'RecipientController@index');
	Route::post('/recipient', 'RecipientController@store');
	Route::delete('/recipient/{notification_id}', 'RecipientController@destroy');

	Route::post('mailgun/status', 'MailgunController@update');

	Route::post('/nexmo', 'NexmoController@incoming');
});


Route::group(['prefix' => 'v1/forums', 'namespace' => 'Forums'], function() {

	Route::get('/setup/{categoryId}', 'ForumController@index');
	Route::get('/hidden', 'ForumController@hidden');

	Route::get('categories', 'CategoryController@index');
	Route::get('categories/all', 'CategoryController@all');
	Route::post('/category', 'CategoryController@store');
	Route::put('/category/{id}', 'CategoryController@destroy');

	Route::get('channels/all', 'ChannelController@all');
	Route::get('channels/{categoryId}', 'ChannelController@index');
	Route::get('channel/{id}', 'ChannelController@show');
	Route::post('/channel', 'ChannelController@store');
	Route::put('/channel/{id}', 'ChannelController@destroy');

	Route::get('/threads/hidden', 'ThreadController@hidden');
	Route::get('/threads/category/{categoryId}', 'ThreadController@category');
	Route::get('/threads/channel/{channelId}', 'ThreadController@channel');
	Route::get('/thread/{id}/show', 'ThreadController@show');
	Route::get('/thread/{id}/edit', 'ThreadController@edit');
	Route::post('/thread', 'ThreadController@store');
	Route::put('/thread', 'ThreadController@update');
	Route::patch('/thread', 'ThreadController@destroy');

	Route::get('/replies/{threadId}', 'ReplyController@index');
	Route::get('/reply/{id}/edit', 'ReplyController@edit');
	Route::post('/reply', 'ReplyController@store');
	Route::patch('/reply', 'ReplyController@update');
	Route::put('/reply/{id}', 'ReplyController@toggle');
	Route::delete('/reply/{id}', 'ReplyController@destroy');

	Route::get('/followed/{userId}', 'FollowedController@index');
	Route::post('/follow/thread', 'FollowedController@thread');
	Route::post('/follow/channel', 'FollowedController@channel');
	
	Route::post('/attachment/image', 'AttachmentController@storeImage');
	Route::post('/attachment/thread', 'AttachmentController@thread');
	Route::delete('/attachment/{id}', 'AttachmentController@destroy');

	Route::post('/search', 'SearchController@index');
});

//Mail gun webhooks

