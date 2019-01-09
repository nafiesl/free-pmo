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

    Route::get('log-files/{filename}', ['as' => 'log-files.show', 'uses' => function ($fileName) {
        if (file_exists(storage_path('logs/'.$fileName))) {
            return response()->file(storage_path('logs/'.$fileName), ['content-type' => 'text/plain']);
        }

        return 'Invalid file name.';
    }]);

    Route::get('log-files/{filename}/download', ['as' => 'log-files.download', 'uses' => function ($fileName) {
        if (file_exists(storage_path('logs/'.$fileName))) {
            return response()->download(storage_path('logs/'.$fileName), env('APP_ENV').'.'.$fileName);
        }

        return 'Invalid file name.';
    }]);
});
