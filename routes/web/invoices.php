<?php

Route::group(['middleware' => ['web','role:admin']], function() {
    /*
     * Invoice Draft Routes
     */
    Route::get('invoices/create', 'InvoiceDraftController@index')->name('invoices.create-empty');
    Route::get('invoices/create/{draftKey?}', 'InvoiceDraftController@show')->name('invoices.create');
    Route::post('invoices/create/{draftKey}', 'InvoiceDraftController@store')->name('invoices.store');
    Route::post('invoices/add-draft', 'InvoiceDraftController@add')->name('invoices.add');
    Route::post('cart/add-draft-item/{draftKey}', 'InvoiceDraftController@addDraftItem')->name('cart.add-draft-item');
    Route::patch('cart/update-draft-item/{draftKey}', 'InvoiceDraftController@updateDraftItem')->name('cart.update-draft-item');
    Route::patch('cart/{draftKey}/proccess', 'InvoiceDraftController@proccess')->name('cart.draft-proccess');
    Route::delete('cart/remove-draft-item/{draftKey}', 'InvoiceDraftController@removeDraftItem')->name('cart.remove-draft-item');
    Route::delete('cart/empty/{draftKey}', 'InvoiceDraftController@empty')->name('cart.empty');
    Route::delete('cart/remove', 'InvoiceDraftController@remove')->name('cart.remove');
    Route::delete('cart/destroy', 'InvoiceDraftController@destroy')->name('cart.destroy');

    /*
     * Invoices Routes
     */
    Route::get('invoices/{invoice}', ['as' => 'invoices.show', 'uses' => 'InvoicesController@show']);
});
