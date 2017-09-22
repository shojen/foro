<?php
Route::get('register', [
	'uses' 	=> 'RegisterController@create',
	'as'	=> 'register'
]);	

Route::post('register', [
	'uses' 	=> 'RegisterController@store'
]);	

Route::get('register/confirmation',[
	'uses'	=> 'RegisterController@confirm',
	'as'	=> 'register_confirmation'
]);

Route::get('login', [
	'uses' 	=> 'LoginController@create',
	'as'	=> 'login'
]);

Route::post('login', [
	'uses' 	=> 'LoginController@store',	
]);
