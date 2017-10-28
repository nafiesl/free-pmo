<?php

Route::group(['namespace' => 'References', 'middleware' => ['web', 'auth']], function () {
    /**
     * Options Routes
     */
    Route::get('options', ['as' => 'options.index', 'uses' => 'OptionsController@index']);
    Route::post('options/store', ['as' => 'options.store', 'uses' => 'OptionsController@store']);
    Route::patch('options/save', ['as' => 'options.save', 'uses' => 'OptionsController@save']);
    Route::delete('options/{optionId}/destroy', ['as' => 'options.destroy', 'uses' => 'OptionsController@destroy']);
});
