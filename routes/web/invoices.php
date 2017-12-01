<?php

Route::group(['middleware' => ['web', 'role:admin']], function () {
    /*
     * Invoice Drafts Routes
     */
    Route::get('invoice-drafts', 'InvoiceDraftsController@index')->name('invoice-drafts.index');
    Route::get('invoice-drafts/{draftKey}', 'InvoiceDraftsController@show')->name('invoice-drafts.show');
    Route::post('invoice-drafts', 'InvoiceDraftsController@create')->name('invoice-drafts.create');
    Route::post('invoice-drafts/{draftKey}/add-draft-item', 'InvoiceDraftsController@addDraftItem')->name('invoice-drafts.add-draft-item');
    Route::patch('invoice-drafts/{draftKey}/update-draft-item', 'InvoiceDraftsController@updateDraftItem')->name('invoice-drafts.update-draft-item');
    Route::patch('invoice-drafts/{draftKey}/proccess', 'InvoiceDraftsController@proccess')->name('invoice-drafts.draft-proccess');
    Route::delete('invoice-drafts/{draftKey}/remove-draft-item', 'InvoiceDraftsController@removeDraftItem')->name('invoice-drafts.remove-draft-item');
    Route::delete('invoice-drafts/{draftKey}/empty-draft', 'InvoiceDraftsController@emptyDraft')->name('invoice-drafts.empty-draft');
    Route::delete('invoice-drafts/{draftKey}/remove', 'InvoiceDraftsController@remove')->name('invoice-drafts.remove');
    Route::delete('invoice-drafts/destroy', 'InvoiceDraftsController@destroy')->name('invoice-drafts.destroy');
    Route::post('invoice-drafts/{draftKey}/store', 'InvoiceDraftsController@store')->name('invoice-drafts.store');

    /*
     * Invoices Routes
     */
    Route::get('invoices/{invoice}', ['as' => 'invoices.show', 'uses' => 'InvoicesController@show']);
    Route::get('invoices/{invoice}/pdf', ['as' => 'invoices.pdf', 'uses' => 'InvoicesController@pdf']);
});
