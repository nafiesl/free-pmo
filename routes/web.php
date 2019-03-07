<?php

require __DIR__.'/web/pages.php';
require __DIR__.'/web/users.php';
require __DIR__.'/web/references.php';
require __DIR__.'/web/account.php';
require __DIR__.'/web/projects.php';
require __DIR__.'/web/payments.php';
require __DIR__.'/web/reports.php';
require __DIR__.'/web/invoices.php';
require __DIR__.'/web/calendar.php';

Route::group(['middleware' => ['role:admin']], function () {
    /*
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
    Route::get('customers/{customer}/projects', ['as' => 'customers.projects', 'uses' => 'Customers\ProjectsController@index']);
    Route::get('customers/{customer}/payments', ['as' => 'customers.payments', 'uses' => 'Customers\PaymentsController@index']);
    Route::get('customers/{customer}/subscriptions', ['as' => 'customers.subscriptions', 'uses' => 'Customers\SubscriptionsController@index']);
    Route::get('customers/{customer}/invoices', ['as' => 'customers.invoices', 'uses' => 'Customers\InvoicesController@index']);
    Route::resource('customers', 'Partners\CustomersController');

    /*
     * Vendors Routes
     */
    Route::apiResource('vendors', 'Partners\VendorsController');
});
