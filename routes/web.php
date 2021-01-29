<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

///////////////////////////////////////////////////////////////////////////////////
// Login, logout, register, profil ///////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
Route::post('/login', 'LoginController@authenticate')->name('login');
Route::get('/github/login', 'LoginGithubController@authenticate')->name('github.login');
Route::get('/github/login/callback', 'LoginGithubController@callback')->name('github.login.callback');
Route::get('/google/login', 'LoginGoogleController@authenticate')->name('google.login');
Route::get('/google/login/callback', 'LoginGoogleController@callback')->name('google.login.callback');
Route::get('/facebook/login', 'LoginFacebookController@authenticate')->name('facebook.login');
Route::get('/facebook/login/callback', 'LoginFacebookController@callback')->name('facebook.login.callback');
Route::get('/logout', 'LoginController@logout')->name('logout');
Route::post('/register', 'RegisterController@register')->name('register');
Route::get('/register/confirm-email/{id}/{token}', 'RegisterController@confirmEmail')->name('register.confirm-email');
Route::get('/profil/id', 'UserController@detail')->name('user.detail');

// Comments ///////////////////////////////////////////////////////////////////////
Route::post( 'show-comments', 'ArticleController@showComments' )->name( 'show-comments' );
Route::post('/add-comment', 'ArticleController@addComment')->name('add-comment');

///////////////////////////////////////////////////////////////////////////////////
// Placeholder routes ////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
Route::get('/{slug?}', 'ArticleController@index')->name('articles');


///////////////////////////////////////////////////////////////////////////////////
// Admin /////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
Route::middleware('admin')->group(function() {
	Route::prefix('admin')->group(function () {
		Route::name('admin.')->group(function () {
			Route::get('/articles', 'ArticleController@index')->name('articles');
			Route::get('/articles/edit/{id}', 'ArticleController@edit')->name('articles.edit');
		});
	});
});