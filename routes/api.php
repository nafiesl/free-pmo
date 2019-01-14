<?php

Route::group(['prefix' => 'v1', 'namespace' => 'Api', 'as' => 'api.', 'middleware' => ['auth:api']], function () {
    require __DIR__.'/api/projects.php';
    /*
     * Calendar
     */
    Route::get('get-events', ['as' => 'events.index', 'uses' => 'EventsController@index']);
    Route::post('events', ['as' => 'events.store', 'uses' => 'EventsController@store']);
    Route::patch('events/update', ['as' => 'events.update', 'uses' => 'EventsController@update']);
    Route::patch('events/reschedule', ['as' => 'events.reschedule', 'uses' => 'EventsController@reschedule']);
    Route::delete('events/delete', ['as' => 'events.destroy', 'uses' => 'EventsController@destroy']);

    /*
     * Customer Route
     */
    Route::post('customers', 'CustomerController@index')->name('customers.index');

    /*
     * Vendor Route
     */
    Route::post('vendors', 'VendorController@index')->name('vendors.index');
});
