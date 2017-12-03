<?php

/**
 * Pages Routes.
 */
Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('about', ['as' => 'about', 'uses' => 'PagesController@about', 'middleware' => ['web']]);
Route::get('home', ['as' => 'home', 'uses' => 'PagesController@home', 'middleware' => ['web', 'auth']]);
