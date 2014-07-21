<?php

Route::get('/', 'HomeController@showWelcome');

Route::group(array('prefix' => '/user'), function()
{
	Route::get('/login', 'UsersController@getLogin');
	Route::post('/login', 'UsersController@postLogin');

	Route::get('/logout', 'UsersController@getLogout');

	Route::group(array('before' => 'auth'), function()
	{
		Route::get('/home', 'UsersController@getUserHome');
	});
});

Route::group(array('prefix' => '/api'), function()
{
	Route::get('/event/recent', 'SeventController@getApiRecentEvent');
});