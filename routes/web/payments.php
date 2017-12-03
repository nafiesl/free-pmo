<?php

Route::group(['middleware' => ['web', 'role:admin']], function () {
    /*
     * Payments Routes
     */
    Route::get('payments/{payment}/pdf', ['as' => 'payments.pdf', 'uses' => 'PaymentsController@pdf']);
    Route::get('payments/{payment}/delete', ['as' => 'payments.delete', 'uses' => 'PaymentsController@delete']);
    Route::resource('payments', 'PaymentsController');
});
