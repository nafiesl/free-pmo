<?php

Route::group(['middleware' => ['web','role:admin'], 'namespace' => 'Projects'], function() {
    /**
     * Projects Routes
     */
    Route::get('projects/{id}/delete', ['as'=>'projects.delete', 'uses'=>'ProjectsController@delete']);
    Route::get('projects/{id}/features', ['as'=>'projects.features', 'uses'=>'ProjectsController@features']);
    Route::get('projects/{id}/payments', ['as'=>'projects.payments', 'uses'=>'ProjectsController@payments']);
    Route::resource('projects','ProjectsController');

    /**
     * Features Routes
     */
    Route::get('projects/{id}/features/create', ['as'=>'features.create', 'uses'=>'FeaturesController@create']);
    Route::resource('features','FeaturesController',['except' => ['index','create']]);
});
