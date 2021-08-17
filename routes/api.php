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
		Route::post('/article/store/{id?}', 'ArticlesController@store')->name('api-article-store');
		Route::get('/article/edit/{id}', 'ArticlesController@edit')->name('api-article-edit');
		Route::get('/article/visibility/{id}', 'ArticlesController@visibility')->name('api-article-visibility');
		Route::get('/article/delete/{id}', 'ArticlesController@delete')->name('api-article-delete');
		Route::post('/images/add', 'ImageController@store')->name('api-images-add');

		Route::get('/categories', 'CategoryController@index')->name('api-categories');
		Route::post('/category/store/{id?}', 'CategoryController@store')->name('api-category-store');
		Route::get('/category/edit/{id}', 'CategoryController@edit')->name('api-category-edit');
		Route::get('/category/delete/{id}', 'CategoryController@delete')->name('api-category-delete');
		Route::get('/category/visibility/{id}', 'CategoryController@visibility')->name('api-category-delete');
		Route::get('/category/select-categories', 'CategoryController@getSelectCategories')->name('api-category-select-categories');
	});
});
