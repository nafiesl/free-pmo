<?php

Route::group(['middleware' => ['web', 'role:admin'], 'namespace' => 'Users'], function () {
    /*
     * Users Routes
     */
    Route::get('users/{user}/jobs', ['as' => 'users.jobs', 'uses' => 'JobsController@index']);
    Route::get('users/{user}/delete', ['as' => 'users.delete', 'uses' => 'UsersController@delete']);
    Route::resource('users', 'UsersController');
});
