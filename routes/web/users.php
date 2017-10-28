<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Users'], function () {
    /**
     * Users Routes
     */
    Route::get('users/{id}/delete', ['as' => 'users.delete', 'uses' => 'UsersController@delete']);
    Route::resource('users', 'UsersController');

    /**
     * Roles Routes
     */
    Route::resource('roles', 'RolesController');
});
