<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::post('insert_kriteria' , 'AhpController@insert_kriteria');

Route::post('insert_matriks', 'AhpController@insert_matriks');
Route::post('reset_matriks', 'AhpController@reset_matriks');
Route::post('do_ahp', 'AhpController@doAhp');