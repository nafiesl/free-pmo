<?php

Route::group(['prefix' => 'v1', 'namespace' => 'Api', 'as' => 'api.', 'middleware' => ['auth:api']], function () {
    require __DIR__.'/api/projects.php';

    /*
     * Jobs
     */
    Route::resource('jobs', 'JobsController', ['only' => ['index', 'show', 'store', 'update']]);
    Route::get('jobs/{job}/comments', 'JobCommentsController@index')->name('jobs.comments.index');
    Route::post('jobs/{job}/comments', 'JobCommentsController@store')->name('jobs.comments.store');

    /*
     * Tasks
     */
    Route::post('tasks', 'TaskController@store')->name('tasks.store');
    Route::patch('tasks/{task}', 'TaskController@update')->name('tasks.update');

    /*
     * Payments
     */
    Route::resource('payments', 'PaymentController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

    /*
     * Subscriptions
     */
    Route::resource('subscriptions', 'SubscriptionController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

    /*
     * Calendar
     */
    Route::get('get-events', ['as' => 'events.index', 'uses' => 'EventsController@index']);
    Route::post('events', ['as' => 'events.store', 'uses' => 'EventsController@store']);
    Route::patch('events/update', ['as' => 'events.update', 'uses' => 'EventsController@update']);
    Route::patch('events/reschedule', ['as' => 'events.reschedule', 'uses' => 'EventsController@reschedule']);
    Route::delete('events/delete', ['as' => 'events.destroy', 'uses' => 'EventsController@destroy']);
    Route::get('events/subscriptions', ['as' => 'events.subscriptions.index', 'uses' => 'SubscriptionEventController@index']);

    /*
     * References (picker)
     */
    Route::get('references/customers', 'ReferencesController@customers')->name('references.customers');
    Route::get('references/vendors', 'ReferencesController@vendors')->name('references.vendors');

    /*
     * Customer Route (RESTful)
     */
    Route::resource('customers', 'CustomerController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

    /*
     * Vendor Route (RESTful)
     */
    Route::resource('vendors', 'VendorController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
});
