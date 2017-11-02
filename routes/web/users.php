<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Users'], function () {
    /**
     * Users Routes
     */
    Route::get('users/{user}/delete', ['as' => 'users.delete', 'uses' => 'UsersController@delete']);
    Route::resource('users', 'UsersController');
});
