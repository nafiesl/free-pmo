<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Projects'], function () {
    /**
     * Projects Routes
     */
    Route::get('projects/{id}/delete', ['as' => 'projects.delete', 'uses' => 'ProjectsController@delete']);
    Route::get('projects/{id}/jobs', ['as' => 'projects.jobs', 'uses' => 'ProjectsController@jobs']);
    Route::get('projects/{id}/jobs-export/{type?}', ['as' => 'projects.jobs-export', 'uses' => 'ProjectsController@jobsExport']);
    Route::get('projects/{id}/payments', ['as' => 'projects.payments', 'uses' => 'ProjectsController@payments']);
    Route::get('projects/{id}/subscriptions', ['as' => 'projects.subscriptions', 'uses' => 'ProjectsController@subscriptions']);
    Route::post('projects/{id}/jobs-reorder', ['as' => 'projects.jobs-reorder', 'uses' => 'ProjectsController@jobsReorder']);
    Route::patch('projects/{id}/status-update', ['as' => 'projects.status-update', 'uses' => 'ProjectsController@statusUpdate']);
    Route::resource('projects', 'ProjectsController');

    /**
     * Project Invoices Routes
     */
    Route::get('projects/{project}/invoices', ['as' => 'projects.invoices', 'uses' => 'InvoicesController@index']);

    /**
     * Jobs Routes
     */
    Route::get('projects/{id}/jobs/create', ['as' => 'jobs.create', 'uses' => 'JobsController@create']);
    Route::get('projects/{id}/jobs/add-from-other-project', ['as' => 'jobs.add-from-other-project', 'uses' => 'JobsController@addFromOtherProject']);
    Route::post('jobs/{id}/tasks-reorder', ['as' => 'jobs.tasks-reorder', 'uses' => 'JobsController@tasksReorder']);
    Route::post('projects/{id}/jobs', ['as' => 'jobs.store', 'uses' => 'JobsController@store']);
    Route::post('projects/{id}/jobs/store-from-other-project', ['as' => 'jobs.store-from-other-project', 'uses' => 'JobsController@storeFromOtherProject']);
    Route::get('jobs/{id}/delete', ['as' => 'jobs.delete', 'uses' => 'JobsController@delete']);
    Route::resource('jobs', 'JobsController', ['except' => ['create', 'store']]);

    /**
     * Tasks Routes
     */
    Route::get('jobs/{id}/tasks/create', ['as' => 'tasks.create', 'uses' => 'TasksController@create']);
    Route::post('jobs/{id}/tasks', ['as' => 'tasks.store', 'uses' => 'TasksController@store']);
    Route::patch('task/{id}', ['as' => 'tasks.update', 'uses' => 'TasksController@update']);
    Route::delete('task/{id}', ['as' => 'tasks.destroy', 'uses' => 'TasksController@destroy']);

    /**
     * Files Routes
     */
    Route::get('projects/{project}/files', ['as' => 'projects.files', 'uses' => 'FilesController@index']);
    Route::post('files/{fileable}', ['as' => 'files.upload', 'uses' => 'FilesController@create']);
    Route::get('files/{file}', ['as' => 'files.download', 'uses' => 'FilesController@show']);
    Route::patch('files/{file}', ['as' => 'files.update', 'uses' => 'FilesController@update']);
});
