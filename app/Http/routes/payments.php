<?php

Route::group(['middleware' => ['web','role:admin']], function() {
    /**
     * Payments Routes
     */
    Route::get('payments/{id}/delete', ['as'=>'payments.delete', 'uses'=>'PaymentsController@delete']);
    Route::resource('payments','PaymentsController');
});
