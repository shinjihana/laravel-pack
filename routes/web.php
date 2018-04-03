<?php

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
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/** Processing Threads */
Route::get('/threads', 'ThreadsController@index');
Route::get('/threads/create', 'ThreadsController@create');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');

Route::post('/threads', 'ThreadsController@store')->middleware('must-be-confirmed');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');

Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');

/** Processing Reply */
/**------- Favorite processing ----------*/
Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');
/**------- Favorite processing ----------*/

Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::delete('/replies/{reply}', 'RepliesController@destroy');
Route::patch('/replies/{reply}', 'RepliesController@update');

/**============== Ending Processing Reply ==============*/

/**========== Processing Subscription ==========*/
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy');
/**========== Processing Subscription ==========*/
/**
 * maybe use Route::resource('threads', 'ThreadsController');
 */

/** ==============Profile User============== */
Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy'); //notification
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index'); //notification
/** ==============Profile User============== */

/** Thread-Channel */
// Route::get('/threads/{channel}', 'ChannelsController@index');
Route::get('/threads/{channel}', 'ThreadsController@index');

/** For User */
Route::get('/register/confirm', 'Api\RegisterConfirmationController@index');

/**Api user */
Route::post('/api/users/{user}/avatar', 'Api\UserAvatarController@store');