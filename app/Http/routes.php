<?php

Route::get('/test', 'Repository\UserRepository\UserRepository@insert');

Route::get('/{request}', 'Service\BaseCallerService@connect');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
