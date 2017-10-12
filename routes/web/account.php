<?php
/**
 * Account Routes
 */
Route::group(['middleware' => 'web','as'=>'auth.'], function() {
    Route::get('login', ['as'=>'login', 'uses' => 'AuthController@getLogin']);
    Route::post('login', ['as'=>'login', 'uses' => 'AuthController@postLogin']);
    Route::get('logout', ['as'=>'logout', 'uses' => 'AuthController@getLogout']);
    Route::get('register', ['as'=>'register', 'uses' => 'AuthController@getRegister']);
    Route::post('register', ['as'=>'register', 'uses' => 'AuthController@postRegister']);
    Route::get('activate', ['as'=>'activate', 'uses' => 'AuthController@getActivate']);
    Route::get('profile', ['as'=>'profile', 'uses' => 'AuthController@getProfile']);
    Route::patch('profile', ['as'=>'profile', 'uses' => 'AuthController@patchProfile']);
});

// Change Password Routes...
Route::get('change-password', 'Auth\ChangePasswordController@show')->name('auth.change-password');
Route::patch('change-password', 'Auth\ChangePasswordController@update')->name('auth.change-password');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.reset-request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.reset-email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('reset-password');