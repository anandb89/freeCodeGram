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

use App\Mail\NewUserWelcomeMail;


Auth::routes();

Route::get('/email', function() {
    return new NewUserWelcomeMail();
});

//Temporary route for checking the email functionality
Route::get('');

//New axios call from the FollowButton.vue file
Route::post('follow/{user}', 'FollowsController@store');

Route::get('/','PostsController@index');
//URL goes to post controller and hits the create method
Route::get('/p/create', 'PostsController@create');

//Route below is conflicting with /p/create as it's taking anything after p, so we'll move it after the create route - ORDER MATTERS!
Route::get('/p/{post}', 'PostsController@show');


//Page that allows to upload photo and caption, URL goes to post controller and hits the store method
Route::post('/p', 'PostsController@store');

Route::get('/profile/{user}', 'ProfilesController@index')->name('profile.show');

//Edit profile route - goes to @edit action
//Now let's create edit method in Profiles Controller
//show profile
Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');

//update profile
Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');
