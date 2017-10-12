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
});

// User Profile Routes...
Route::get('profile', ['uses' => 'Auth\ProfileController@show'])->name('auth.profile');
Route::patch('profile', ['uses' => 'Auth\ProfileController@update'])->name('auth.profile');

// Change Password Routes...
Route::get('change-password', 'Auth\ChangePasswordController@show')->name('auth.change-password');
Route::patch('change-password', 'Auth\ChangePasswordController@update')->name('auth.change-password');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.reset-request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.reset-email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('reset-password');