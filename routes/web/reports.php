<?php

Route::group(['middleware' => ['web', 'role:admin'], 'prefix' => 'reports'], function () {
    /*
     * Reports Routes
     */
    Route::get('payments', 'ReportsController@monthly')->name('reports.payments.index');
    Route::get('payments/daily', 'ReportsController@daily')->name('reports.payments.daily');
    Route::get('payments/monthly', 'ReportsController@monthly')->name('reports.payments.monthly');
    Route::get('payments/yearly', 'ReportsController@yearly')->name('reports.payments.yearly');
    Route::get('payments/year_to_year', 'ReportsController@yearToYear')->name('reports.payments.year_to_year');
    Route::get('current-credits', 'ReportsController@currentCredits')->name('reports.current-credits');

    /*
     * Log Files Routes
     */
    Route::get('log-files', 'Reports\LogFileController@index')->name('log-files.index');
    Route::get('log-files/{fileName}', 'Reports\LogFileController@show')->name('log-files.show');
    Route::get('log-files/{fileName}/download', 'Reports\LogFileController@download')->name('log-files.download');
});
