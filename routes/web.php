<?php

require __DIR__.'/web/pages.php';
require __DIR__.'/web/users.php';
require __DIR__.'/web/references.php';
require __DIR__.'/web/account.php';
require __DIR__.'/web/projects.php';
require __DIR__.'/web/payments.php';
require __DIR__.'/web/reports.php';
require __DIR__.'/web/invoices.php';
require __DIR__.'/web/options-vue.php';
require __DIR__.'/web/calendar.php';

Route::group(['middleware' => ['web', 'auth']], function () {
    /**
     * Subscriptions Routes
     */
    Route::resource('subscriptions', 'SubscriptionsController');

    /*
     * Backup Restore Database Routes
     */
    Route::post('backups/upload', ['as' => 'backups.upload', 'uses' => 'BackupsController@upload']);
    Route::post('backups/{fileName}/restore', ['as' => 'backups.restore', 'uses' => 'BackupsController@restore']);
    Route::get('backups/{fileName}/dl', ['as' => 'backups.download', 'uses' => 'BackupsController@download']);
    Route::resource('backups', 'BackupsController', ['except' => ['create', 'show', 'edit']]);

    /*
     * Customers Routes
     */
    Route::resource('customers', 'Partners\CustomersController');

    /*
     * Vendors Routes
     */
    Route::apiResource('vendors', 'Partners\VendorsController');
});
