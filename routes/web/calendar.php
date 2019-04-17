<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Users'], function () {
    /*
     * User Calendar Route
     */
    Route::get('my-calendar', 'CalendarController@index')->name('users.calendar');
});
