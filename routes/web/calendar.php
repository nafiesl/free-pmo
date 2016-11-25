<?php

Route::group(['middleware' => ['web','auth'], 'namespace' => 'Api'], function() {
    /**
     * Savety Calendar
     */
    Route::get('my-calendar', ['as' => 'users.calendar', 'uses' => function() {
        return view('users.calendar');
    }]);
});

// Route::group(['middleware' => ['api','auth:api'], 'namespace' => 'Api'], function() {
//     /**
//      * Savety Calendar
//      */
//     Route::get('get-events', ['as' => 'api.events.index', 'uses' => 'EventsController@index']);
//     Route::post('events', ['as' => 'api.events.store', 'uses' => 'EventsController@store']);
//     Route::patch('events/update', ['as' => 'api.events.update', 'uses' => 'EventsController@update']);
//     Route::patch('events/reschedule', ['as' => 'api.events.reschedule', 'uses' => 'EventsController@reschedule']);
//     Route::delete('events/delete', ['as' => 'api.events.destroy', 'uses' => 'EventsController@destroy']);
// });
