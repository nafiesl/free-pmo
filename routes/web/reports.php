<?php

Route::group(['middleware' => ['web', 'role:admin'], 'prefix' => 'reports'], function () {
    /*
     * Reports Routes
     */
    Route::get('payments', ['as' => 'reports.payments.index', 'uses' => 'ReportsController@monthly']);
    Route::get('payments/daily', ['as' => 'reports.payments.daily', 'uses' => 'ReportsController@daily']);
    Route::get('payments/monthly', ['as' => 'reports.payments.monthly', 'uses' => 'ReportsController@monthly']);
    Route::get('payments/yearly', ['as' => 'reports.payments.yearly', 'uses' => 'ReportsController@yearly']);
    Route::get('current-credits', ['as' => 'reports.current-credits', 'uses' => 'ReportsController@currentCredits']);

    Route::get('log-files', ['as' => 'log-files.index', 'uses' => 'Reports\LogFileController@index']);
    Route::get('log-files/{filename}', ['as' => 'log-files.show', 'uses' => 'Reports\LogFileController@show']);
    Route::get('log-files/{filename}/download', ['as' => 'log-files.download', 'uses' => 'Reports\LogFileController@download']);
});
