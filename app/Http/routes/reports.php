<?php

Route::group(['middleware' => ['web','role:admin'],'prefix' => 'reports'], function() {
    /**
     * Reports Routes
     */
    Route::get('payments', ['as'=>'reports.payments.index', 'uses' => 'ReportsController@monthly']);
    Route::get('payments/daily', ['as'=>'reports.payments.daily', 'uses' => 'ReportsController@daily']);
    Route::get('payments/monthly', ['as'=>'reports.payments.monthly', 'uses' => 'ReportsController@monthly']);
    Route::get('payments/yearly', ['as'=>'reports.payments.yearly', 'uses' => 'ReportsController@yearly']);
});
