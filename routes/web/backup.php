<?php

Route::group(['middleware' => ['web','role:admin']], function() {
    /**
     * Backups Routes
     */
    Route::get('backups/{fileName}/restore', ['as'=>'backups.restore', 'uses'=>'BackupsController@restore']);
    Route::post('backups/{fileName}/restore', ['as'=>'backups.restore', 'uses'=>'BackupsController@postRestore']);
    Route::get('backups/{fileName}/dl', ['as'=>'backups.download', 'uses'=>'BackupsController@download']);
    Route::post('backups/upload', ['as'=>'backups.upload', 'uses'=>'BackupsController@upload']);
    Route::get('backups/{id}/delete', ['as'=>'backups.delete', 'uses'=>'BackupsController@delete']);
    Route::resource('backups','BackupsController');

});
