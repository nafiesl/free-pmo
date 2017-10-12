<?php
/**
 * Account Routes
 */
Route::group(['middleware' => 'web','as'=>'auth.'], function() {
    Route::get('register', ['as'=>'register', 'uses' => 'AuthController@getRegister']);
    Route::post('register', ['as'=>'register', 'uses' => 'AuthController@postRegister']);
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('auth.logout');

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