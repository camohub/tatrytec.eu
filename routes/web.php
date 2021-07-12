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

Route::get('welcome', 'HomepageController@index')->name('welcome');
Route::get('about', 'HomepageController@about')->name('about');
Route::get('contact', 'HomepageController@contact')->name('contact');

///////////////////////////////////////////////////////////////////////////////////
// Login, logout, register, profil ///////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
Route::namespace('User')->group(function () {
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
	Route::get('/forgotten-password-form', 'ForgottenPasswordController@showForm')->name('forgotten-password-form');
	Route::post('/forgotten-password-email', 'ForgottenPasswordController@sendEmail')->name('forgotten-password-email');
	Route::get('/forgotten-password-change/{token}', 'ForgottenPasswordController@changePassword')->name('forgotten-password-change');
	Route::get('/profil/id', 'UserController@index')->name('user');
	Route::post('/profil/id', 'UserController@changePassword')->name('user.change-password');
});

// Comments ///////////////////////////////////////////////////////////////////////
Route::post( 'show-comments', 'ArticleController@showComments' )->name( 'show-comments' );
Route::post('/add-comment', 'ArticleController@addComment')->name('add-comment');

///////////////////////////////////////////////////////////////////////////////////
// Admin /////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
Route::middleware('admin')->group(function() {
	Route::prefix('admin')->group(function () {
		Route::name('admin.')->group(function () {
			Route::namespace('Admin')->group(function () {
				Route::get('/', 'DefaultController@index')->name('index');
				Route::match(['get', 'post'], '/articles', 'ArticleController@index')->name('articles');  // post for filter form
				Route::get('/articles/create', 'ArticleController@create')->name('articles.create');
				Route::get('/articles/edit/{id}', 'ArticleController@edit')->name('articles.edit');
				Route::post('/articles/store/{id?}', 'ArticleController@store')->name('articles.store');
				Route::post('/articles/visibility/{id}', 'ArticleController@visibility')->name('articles.visibility');
				Route::post('/articles/delete/{id}', 'ArticleController@delete')->name('articles.delete');
				Route::get('/articles/export', 'ArticleController@exportArticles')->name('articles.export');
				Route::get('/comments/{article_id}', 'CommentController@index')->name('comments');
				Route::post('/comments/delete/{article_id}/{comment_id}', 'CommentController@delete')->name('comments.delete');

				Route::get('/categories', 'CategoryController@index')->name('categories');
				Route::get('/categories/sort', 'CategoryController@sort')->name('categories.sort');
				Route::post('/categories/store', 'CategoryController@store')->name('categories.store');
				Route::post('/categories/visibility/{id}', 'CategoryController@visibility')->name('categories.visibility');
				Route::post('/categories/delete/{id}', 'CategoryController@delete')->name('categories.delete');

				Route::get('/images', 'ImageController@index')->name('images');
				Route::post('/images/add', 'ImageController@store')->name('images.add');

				Route::get('/users', 'UserController@index')->name('users');
				Route::post('/users/edit', 'UserController@edit')->name('users.edit');
				Route::post('/users/block/{id}', 'UserController@block')->name('users.block');
				Route::post('/users/email/{id}', 'UserController@email')->name('users.email');

				Route::get('/pages', 'PageController@index')->name('pages');
				Route::get('/pages/create', 'PageController@create')->name('pages.create');
				Route::get('/pages/edit/{id}', 'PageController@edit')->name('pages.edit');
				Route::post('/pages/store/{id?}', 'PageController@store')->name('pages.store');
				Route::post('/pages/visibility/{id}', 'PageController@visibility')->name('pages.visibility');
				Route::post('/pages/delete/{id}', 'PageController@delete')->name('pages.delete');

				Route::get('/drom', 'DromController@index')->name('drom');
			});
		});
	});
});

// Pages //////////////////////////////////////////////////////////////////////////
Route::get('/info/{page}', 'PageController@index')->name('page');
Route::get('/delete/test-data', 'TestDataController@index');
///////////////////////////////////////////////////////////////////////////////////
// Placeholder routes ////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
Route::get('/{slug}/{page?}', 'ArticleController@index')->name('articles');