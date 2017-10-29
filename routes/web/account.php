<?php
/**
 * Account Routes
 */
Route::group(['middleware' => 'web', 'as' => 'auth.'], function () {
    Route::get('register', ['as' => 'register', 'uses' => 'AuthController@getRegister']);
    Route::post('register', ['as' => 'register', 'uses' => 'AuthController@postRegister']);
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
Route::get('change-password', 'Auth\ChangePasswordController@show')->name('auth.change-password');
Route::patch('change-password', 'Auth\ChangePasswordController@update')->name('auth.change-password');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.reset-request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.reset-email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('reset-password');

// User's Profile routes
Route::get('profile', [
    'as'         => 'users.profile.show',
    'uses'       => 'Users\ProfileController@show',
    'middleware' => ['web', 'auth'],
]);

Route::get('profile/edit', [
    'as'         => 'users.profile.edit',
    'uses'       => 'Users\ProfileController@edit',
    'middleware' => ['web', 'auth'],
]);

Route::patch('profile/update', [
    'as'         => 'users.profile.update',
    'uses'       => 'Users\ProfileController@update',
    'middleware' => ['web', 'auth'],
]);

// User's Agency routes
Route::get('agency', [
    'as'         => 'users.agency.show',
    'uses'       => 'Users\AgencyController@show',
    'middleware' => ['web', 'auth'],
]);

Route::get('agency/edit', [
    'as'         => 'users.agency.edit',
    'uses'       => 'Users\AgencyController@edit',
    'middleware' => ['web', 'auth'],
]);

Route::patch('agency/update', [
    'as'         => 'users.agency.update',
    'uses'       => 'Users\AgencyController@update',
    'middleware' => ['web', 'auth'],
]);
