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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('post', 'PostController');
    Route::post('/getall', 'PostController@getall')->name('getall');
    Route::post('/getmodal', 'PostController@getmodal')->name('getmodal');
    
    Route::resource('profile', ProfileController::class);
    // Route::get('profile', 'ProfileController@index')->name('profile');
    Route::get('/facebook', 'ProfileController@redirectToFacebookProvider')->name('facebook');
    Route::get('facebook/callback', 'ProfileController@handleProviderFacebookCallback');
    Route::post('facebook_page_id', 'ProfileController@facebook_page_id')->name('facebook_page_id');
    
    
    Route::post('page', 'GraphController@publishToPage')->name('page');
});
