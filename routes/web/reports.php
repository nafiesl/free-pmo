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

    Route::get('log-files', 'Reports\LogFileController@index')->name('log-files.index');
    Route::get('log-files/{fileName}', 'Reports\LogFileController@show')->name('log-files.show');
    Route::get('log-files/{fileName}/download', 'Reports\LogFileController@download')->name('log-files.download');
});
