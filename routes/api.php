<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v1/notifications', 'namespace' => 'Notifications'], function() {

	Route::get('/all', 'NotificationController@index');
	Route::get('/past', 'NotificationController@past');
	Route::get('/upcoming', 'NotificationController@upcoming');
	Route::get('/show', 'NotificationController@show');
	Route::get('/{id}/edit', 'NotificationController@edit');

	Route::post('/', 'NotificationController@store');
	Route::delete('/{id}', 'NotificationController@destroy');

	Route::get('/recipients', 'RecipientController@index');
	Route::post('/recipient', 'RecipientController@store');
	Route::delete('/recipient/{notification_id}', 'RecipientController@destroy');
});


Route::group(['prefix' => 'v1/forums'], function() {

	Route::get('/forum/setup/{categoryId}', 'ForumController@index');
	Route::get('/forum/hidden', 'ForumController@hidden');

	Route::post('/user', 'UserController@store');

	Route::get('categories', 'CategoryController@index');
	Route::get('categories/all', 'CategoryController@all');
	Route::post('/category', 'CategoryController@store');
	Route::delete('/category/{id}', 'CategoryController@destroy');

	Route::get('channels/all', 'ChannelController@all');
	Route::get('channels/{categoryId}', 'ChannelController@index');
	Route::get('channel/{id}', 'ChannelController@show');
	Route::post('/channel', 'ChannelController@store');
	Route::delete('/channel/{id}', 'ChannelController@destroy');

	Route::get('/threads/{categoryId}', 'ThreadController@index');
	Route::get('/thread/{id}', 'ThreadController@show');
	Route::get('/thread/{id}/edit', 'ThreadController@edit');
	Route::post('/thread', 'ThreadController@store');
	Route::put('/thread/{id}', 'ThreadController@update');
	Route::delete('/thread/{id}', 'ThreadController@destroy');

	Route::get('/reply', 'ReplyController@edit');
	Route::get('/reply/{id}', 'ReplyController@edit');
	Route::post('/reply', 'ReplyController@store');
	Route::put('/reply/{id}', 'ReplyController@update');
	Route::delete('/reply/{id}', 'ReplyController@destroy');

	Route::post('/attachment/image', 'AttachmentController@storeImage');
	Route::post('/attachment/files', 'AttachmentController@storeFiles');
	Route::delete('/attachment/{id}', 'AttachmentController@destroy');

	Route::post('/search', 'SearchController@index');
});
