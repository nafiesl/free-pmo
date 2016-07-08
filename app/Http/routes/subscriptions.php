<?php

Route::group(['middleware' => ['web','role:admin']], function() {
    /**
     * Subscriptions Routes
     */
    Route::get('subscriptions/{id}/delete', ['as'=>'subscriptions.delete', 'uses'=>'SubscriptionsController@delete']);
    Route::resource('subscriptions','SubscriptionsController');
});
