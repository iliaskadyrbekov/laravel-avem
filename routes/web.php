<?php

use Illuminate\Support\Facades\Route;

Route::get('/sign-in', 'LoginController@show')->name('login')->middleware('guest');
Route::get('/sign-up', 'RegistrationController@show')->name('register')->middleware('guest');
Route::post('/sign-in', 'LoginController@authenticate');
Route::post('/sign-up', 'RegistrationController@register');
Route::post('/sign-out', 'LoginController@logout')->middleware('auth');

Route::post('/add-blog', 'BlogController@saveBlog')->middleware('auth')->name('add-blog');
Route::post('/profile-edit/{user_id}', 'EditProfileController@edit')->middleware('auth');

Route::post('/profile-follow/{user_id}', 'UserController@follow');
Route::post('/profile-unfollow/{user_id}', 'UserController@unfollow');
Route::post('/like', 'UserController@like');
Route::post('/bookmark', 'UserController@bookmark');
Route::post('locationresults/city', 'SearchController@locationResult');
Route::post('locationresults/place', 'SearchController@placeResult');
Route::post('globalresults', 'SearchController@globalResult');
Route::post('/blog/{blog_id}/{pages?}', 'BlogController@addComment');

Route::get('/', 'HomeController@show');
Route::get('/home/{pages?}', 'HomeController@show')->name('home');
Route::get('/bookmarks/{pages?}', 'BookmarkController@show')->middleware('auth');
Route::get('/subscriptions/{pages?}', 'UserController@show')->middleware('auth');
Route::get('/profile/{user_id}/{pages?}', 'ProfileController@show');
Route::get('/city/{city_id}/{pages?}', 'CityController@show')->name('city');
Route::get('/place/{place_id}/{pages?}', 'PlaceController@show');

Route::get('/search/s={search_parameter}/{pages?}', 'SearchController@show');
Route::get('/blog/{blog_id}/{pages?}', 'BlogController@show')->name('blog');


Route::get('/add-blog', 'BlogController@addBlog')->middleware('auth');
Route::get('/profile-edit/{user_id}', 'EditProfileController@show')->middleware('auth');




