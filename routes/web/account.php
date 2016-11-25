<?php
/**
 * Account Routes
 */
Route::group(['prefix' => 'auth','middleware' => 'web','as'=>'auth.'], function() {
    Route::get('login', ['as'=>'login', 'uses' => 'AuthController@getLogin']);
    Route::post('login', ['as'=>'login', 'uses' => 'AuthController@postLogin']);
    Route::get('logout', ['as'=>'logout', 'uses' => 'AuthController@getLogout']);
    Route::get('register', ['as'=>'register', 'uses' => 'AuthController@getRegister']);
    Route::post('register', ['as'=>'register', 'uses' => 'AuthController@postRegister']);
    Route::get('activate', ['as'=>'activate', 'uses' => 'AuthController@getActivate']);
    Route::get('change-password', ['as'=>'change-password', 'uses' => 'AuthController@getChangePassword']);
    Route::post('change-password', ['as'=>'change-password', 'uses' => 'AuthController@postChangePassword']);
    // Route::get('forgot-password', ['as'=>'forgot-password', 'uses' => 'AuthController@getEmail']);
    // Route::post('forgot-password', ['as'=>'forgot-password', 'uses' => 'AuthController@postEmail']);
    // Route::get('reset/{token}', ['as'=>'reset', 'uses' => 'AuthController@getReset']);
    // Route::post('reset', ['as'=>'post-reset', 'uses' => 'AuthController@postReset']);
    Route::get('profile', ['as'=>'profile', 'uses' => 'AuthController@getProfile']);
    Route::patch('profile', ['as'=>'profile', 'uses' => 'AuthController@patchProfile']);
});

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.reset-request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.reset-email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('auth.reset-password');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.reset-password');