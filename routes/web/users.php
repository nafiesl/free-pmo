<?php

Route::group(['middleware' => ['web','role:admin'], 'namespace' => 'Users'], function() {
    /**
     * Users Routes
     */
    Route::get('users/{id}/delete', ['as'=>'users.delete', 'uses'=>'UsersController@delete']);
    Route::resource('users','UsersController');

    /**
     * Permissions Routes
     */
    Route::resource('permissions','PermissionsController');

    /**
     * Roles Routes
     */
    Route::resource('roles','RolesController');
    Route::post('roles/{id}/update-permissions', ['as' => 'roles.update-permissions', 'uses' => 'RolesController@updatePermissions']);
});
