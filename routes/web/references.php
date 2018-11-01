<?php

Route::group(['namespace' => 'References', 'middleware' => ['web', 'role:admin']], function () {
    /*
     * Options Routes
     */
    Route::get('options', ['as' => 'options.index', 'uses' => 'OptionsController@index']);
    Route::post('options/store', ['as' => 'options.store', 'uses' => 'OptionsController@store']);
    Route::patch('options/save', ['as' => 'options.save', 'uses' => 'OptionsController@save']);
    Route::delete('options/{optionId}/destroy', ['as' => 'options.destroy', 'uses' => 'OptionsController@destroy']);

    /*
     * Site Options Routes
     */
    Route::get('site-options', ['as' => 'site-options.page-1', 'uses' => 'SiteOptionsController@page1']);
    Route::patch('site-options/save-1', ['as' => 'site-options.save-1', 'uses' => 'SiteOptionsController@save1']);

    /*
     * Bank Accounts Routes
     */
    Route::apiResource('bank-accounts', 'BankAccountsController');
    Route::post('bank-accounts/import', 'BankAccountsController@import')->name('bank-accounts.import');
});
