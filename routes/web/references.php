<?php

Route::group(['namespace' => 'References','middleware'=>['web','role:admin']], function() {
    /**
     * Options Routes
     */
    Route::get('options', ['as'=>'options.index' , 'uses'=>'OptionsController@index']);
    Route::get('options/create', ['as'=>'options.create' , 'uses'=>'OptionsController@create']);
    Route::post('options/store', ['as'=>'options.store' , 'uses'=>'OptionsController@store']);
    Route::patch('options/save', ['as'=>'options.save' , 'uses'=>'OptionsController@save']);
    Route::get('options/{id}/delete', ['as'=>'options.delete' , 'uses'=>'OptionsController@delete']);
    Route::delete('options/{optionId}/destroy', ['as'=>'options.destroy' , 'uses'=>'OptionsController@destroy']);
});