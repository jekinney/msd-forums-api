<?php

use Illuminate\Http\Request;


Route::post('v1/user', 'UserController@store');

Route::group(['prefix' => 'v1/notifications', 'namespace' => 'Notifications'], function() {

	Route::get('/all', 'NotificationController@index');
	Route::get('/past', 'NotificationController@past');
	Route::get('/upcoming', 'NotificationController@upcoming');
	Route::get('/{id}', 'NotificationController@show');

	Route::post('/', 'NotificationController@store');
	Route::post('/test', 'NotificationController@test');
	Route::delete('/{id}', 'NotificationController@destroy');

	Route::get('/recipients', 'RecipientController@index');
	Route::post('/recipient', 'RecipientController@store');
	Route::delete('/recipient/{notification_id}', 'RecipientController@destroy');

	Route::post('mailgun/status', 'MailgunController@update');
});


Route::group(['prefix' => 'v1/forums', 'namespace' => 'Forums'], function() {

	Route::get('/setup/{categoryId}', 'ForumController@index');
	Route::get('/hidden', 'ForumController@hidden');

	Route::get('categories', 'CategoryController@index');
	Route::get('categories/all', 'CategoryController@all');
	Route::post('/category', 'CategoryController@store');
	Route::delete('/category/{id}', 'CategoryController@destroy');

	Route::get('channels/all', 'ChannelController@all');
	Route::get('channels/{categoryId}', 'ChannelController@index');
	Route::get('channel/{id}', 'ChannelController@show');
	Route::post('/channel', 'ChannelController@store');
	Route::delete('/channel/{id}', 'ChannelController@destroy');

	Route::get('/threads/hidden', 'ThreadController@hidden');
	Route::get('/threads/{categoryId}', 'ThreadController@index');
	Route::get('/thread/{id}/show', 'ThreadController@show');
	Route::get('/thread/{id}/edit', 'ThreadController@edit');
	Route::post('/thread', 'ThreadController@store');
	Route::put('/thread/{id}', 'ThreadController@update');
	Route::patch('/thread', 'ThreadController@destroy');

	Route::get('/reply', 'ReplyController@edit');
	Route::get('/reply/{id}', 'ReplyController@edit');
	Route::post('/reply', 'ReplyController@store');
	Route::put('/reply/{id}', 'ReplyController@update');
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

