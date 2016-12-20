<?php

Route::group(['middleware' => ['web','auth'], 'namespace' => 'Api'], function() {
    /**
     * Savety Calendar
     */
    Route::get('my-calendar', ['as' => 'users.calendar', 'uses' => function() {
        return view('users.calendar');
    }]);
});