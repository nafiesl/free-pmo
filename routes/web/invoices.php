<?php

Route::group(['middleware' => ['web', 'role:admin'], 'namespace' => 'Invoices'], function () {
    /*
     * Invoice Drafts Routes
     */
    Route::get('invoice-drafts', 'DraftsController@index')->name('invoice-drafts.index');
    Route::get('invoice-drafts/{draftKey}', 'DraftsController@show')->name('invoice-drafts.show');
    Route::post('invoice-drafts', 'DraftsController@create')->name('invoice-drafts.create');
    Route::post('invoice-drafts/{draftKey}/add-draft-item', 'DraftsController@addDraftItem')->name('invoice-drafts.add-draft-item');
    Route::patch('invoice-drafts/{draftKey}/update-draft-item', 'DraftsController@updateDraftItem')->name('invoice-drafts.update-draft-item');
    Route::patch('invoice-drafts/{draftKey}/proccess', 'DraftsController@proccess')->name('invoice-drafts.draft-proccess');
    Route::delete('invoice-drafts/{draftKey}/remove-draft-item', 'DraftsController@removeDraftItem')->name('invoice-drafts.remove-draft-item');
    Route::delete('invoice-drafts/{draftKey}/empty-draft', 'DraftsController@emptyDraft')->name('invoice-drafts.empty-draft');
    Route::delete('invoice-drafts/{draftKey}/remove', 'DraftsController@remove')->name('invoice-drafts.remove');
    Route::delete('invoice-drafts/destroy', 'DraftsController@destroy')->name('invoice-drafts.destroy');
    Route::post('invoice-drafts/{draftKey}/store', 'DraftsController@store')->name('invoice-drafts.store');

    /*
     * Invoices Routes
     */
    Route::get('invoices/{invoice}/pdf', ['as' => 'invoices.pdf', 'uses' => 'InvoicesController@pdf']);
    Route::resource('invoices', 'InvoicesController');

    /*
     * Invoice Items Routes
     */
    Route::post('invoices/{invoice}/items', ['as' => 'invoices.items.store', 'uses' => 'ItemsController@store']);
    Route::patch('invoices/{invoice}/items', ['as' => 'invoices.items.update', 'uses' => 'ItemsController@update']);
    Route::delete('invoices/{invoice}/items', ['as' => 'invoices.items.destroy', 'uses' => 'ItemsController@destroy']);

    /*
     * Invoice Duplication Route
     */
    Route::post('invoices/{invoice}/duplicate', ['as' => 'invoices.duplication.store', 'uses' => 'DuplicationController@store']);
});
