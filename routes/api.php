<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::namespace('User')->group(function () {
	Route::post('/vue-admin/login', 'LoginVueController@authenticate')->name('login-vue-admin');
});


Route::namespace('Api')->group(function () {
	//Route::get('/articles', 'ArticlesController@index')->name('api-articles');
	Route::middleware('auth:api')->group(function () {
		Route::get('/articles', 'ArticlesController@index')->name('api-articles');
	});
});
