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
    Route::get('projects/{id}/features/add-from-other-project', ['as'=>'features.add-from-other-project', 'uses'=>'FeaturesController@addFromOtherProject']);
    Route::post('projects/{id}/features', ['as'=>'features.store', 'uses'=>'FeaturesController@store']);
    Route::post('projects/{id}/features/store-from-other-project', ['as'=>'features.store-from-other-project', 'uses'=>'FeaturesController@storeFromOtherProject']);
    Route::get('features/{id}/delete', ['as'=>'features.delete', 'uses'=>'FeaturesController@delete']);
    Route::resource('features','FeaturesController',['except' => ['index','create','store']]);

    /**
     * Tasks Routes
     */
    Route::get('features/{id}/tasks/create', ['as'=>'tasks.create', 'uses'=>'TasksController@create']);
    Route::post('features/{id}/tasks', ['as'=>'tasks.store', 'uses'=>'TasksController@store']);
    Route::patch('task/{id}', ['as'=>'tasks.update', 'uses'=>'TasksController@update']);
    Route::delete('task/{id}', ['as'=>'tasks.destroy', 'uses'=>'TasksController@destroy']);
});
