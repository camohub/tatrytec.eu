<?php

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
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
	Route::middleware('auth:sanctum')->group(function () {
		Route::get('/auth-check', function () {
			//\Illuminate\Support\Facades\Log::debug(Auth::user());
			return response()->json(['user' => new UserResource(Auth::user())]);  // Otherwise it returns error.
		});
		Route::get('/articles', 'ArticlesController@index')->name('api-articles');
		Route::get('/article/visibility/{id}', 'ArticlesController@visibility')->name('api-article-visibility');
		Route::get('/article/edit/{id}', 'ArticlesController@edit')->name('api-article-edit');
		Route::get('/article/delete/{id}', 'ArticlesController@delete')->name('api-article-delete');
		Route::post('/article/store/{id?}', 'ArticlesController@store')->name('api-article-store');
		Route::post('/images/add', 'ImageController@store')->name('api-images-add');
	});
});
