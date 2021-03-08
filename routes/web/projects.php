<?php

Route::group(['middleware' => ['auth'], 'namespace' => 'Projects'], function () {
    /*
     * Projects Routes
     */
    Route::get('projects/{project}/delete', ['as' => 'projects.delete', 'uses' => 'ProjectsController@delete']);
    Route::get('projects/{project}/subscriptions', ['as' => 'projects.subscriptions', 'uses' => 'ProjectsController@subscriptions']);
    Route::patch('projects/{project}/status-update', ['as' => 'projects.status-update', 'uses' => 'ProjectsController@statusUpdate']);
    Route::resource('projects', 'ProjectsController');

    /*
     * Project Payments Routes
     */
    Route::get('projects/{project}/payments', ['as' => 'projects.payments', 'uses' => 'ProjectsController@payments']);

    /*
     * Project Fees Routes
     */
    Route::get('projects/{project}/fees/create', ['as' => 'projects.fees.create', 'uses' => 'FeesController@create']);
    Route::post('projects/{project}/fees/store', ['as' => 'projects.fees.store', 'uses' => 'FeesController@store']);

    /*
     * Project Invoices Routes
     */
    Route::get('projects/{project}/invoices', ['as' => 'projects.invoices', 'uses' => 'InvoicesController@index']);

    /*
     * Project Activities Routes
     */
    Route::get('projects/{project}/activities', ['as' => 'projects.activities.index', 'uses' => 'ActivityController@index']);

    /*
     * Project Jobs Routes
     */
    Route::get('projects/{project}/jobs-export/{type?}', ['as' => 'projects.jobs-export', 'uses' => 'JobsController@jobsExport']);
    Route::get('projects/{project}/job-progress-export/{type?}', ['as' => 'projects.job-progress-export', 'uses' => 'JobsController@jobProgressExport']);
    Route::get('projects/{project}/jobs/create', ['as' => 'projects.jobs.create', 'uses' => 'JobsController@create']);
    Route::post('projects/{project}/jobs', ['as' => 'projects.jobs.store', 'uses' => 'JobsController@store']);
    Route::get('projects/{project}/jobs/add-from-other-project', ['as' => 'projects.jobs.add-from-other-project', 'uses' => 'JobsController@addFromOtherProject']);
    Route::post('projects/{project}/jobs/store-from-other-project', ['as' => 'projects.jobs.store-from-other-project', 'uses' => 'JobsController@storeFromOtherProject']);
    Route::get('projects/{project}/jobs', ['as' => 'projects.jobs.index', 'uses' => 'JobsController@index']);
    Route::post('projects/{project}/jobs-reorder', ['as' => 'projects.jobs-reorder', 'uses' => 'ProjectsController@jobsReorder']);

    /*
     * Project Comments Routes
     */
    Route::get('projects/{project}/comments', 'CommentsController@index')->name('projects.comments.index');
    Route::post('projects/{project}/comments', 'CommentsController@store')->name('projects.comments.store');
    Route::patch('projects/{project}/comments/{comment}', 'CommentsController@update')->name('projects.comments.update');
    Route::delete('projects/{project}/comments/{comment}', 'CommentsController@destroy')->name('projects.comments.destroy');

    /*
     * Project Issues Routes
     */
    Route::get('projects/{project}/issues', 'IssueController@index')->name('projects.issues.index');
    Route::get('projects/{project}/issues/create', 'IssueController@create')->name('projects.issues.create');
    Route::post('projects/{project}/issues', 'IssueController@store')->name('projects.issues.store');
    Route::get('projects/{project}/issues/{issue}', 'IssueController@show')->name('projects.issues.show');
    Route::get('projects/{project}/issues/{issue}/edit', 'IssueController@edit')->name('projects.issues.edit');
    Route::patch('projects/{project}/issues/{issue}', 'IssueController@update')->name('projects.issues.update');
    Route::delete('projects/{project}/issues/{issue}', 'IssueController@destroy')->name('projects.issues.destroy');

    /*
     * Tasks Routes
     */
    Route::get('jobs/{job}/tasks/create', ['as' => 'tasks.create', 'uses' => 'TasksController@create']);
    Route::post('jobs/{job}/tasks', ['as' => 'tasks.store', 'uses' => 'TasksController@store']);
    Route::patch('tasks/{task}', ['as' => 'tasks.update', 'uses' => 'TasksController@update']);
    Route::patch('tasks/{task}/set_done', ['as' => 'tasks.set_done', 'uses' => 'TasksController@setDone']);
    Route::delete('tasks/{task}', ['as' => 'tasks.destroy', 'uses' => 'TasksController@destroy']);
    Route::post('tasks/{task}/set-as-job', ['as' => 'tasks.set-as-job', 'uses' => 'TasksController@setAsJob']);

    /*
     * Files Routes
     */
    Route::get('projects/{project}/files', ['as' => 'projects.files', 'uses' => 'FilesController@index']);
    Route::post('files/{fileable}', ['as' => 'files.upload', 'uses' => 'FilesController@create']);
    Route::get('files/{file}', ['as' => 'files.download', 'uses' => 'FilesController@show']);
    Route::patch('files/{file}', ['as' => 'files.update', 'uses' => 'FilesController@update']);
    Route::delete('files/{file}', ['as' => 'files.destroy', 'uses' => 'FilesController@destroy']);
});

Route::group(['middleware' => ['auth']], function () {

    /*
     * Jobs Routes
     */
    Route::get('jobs', ['as' => 'jobs.index', 'uses' => 'JobsController@index']);
    Route::get('jobs/{job}', ['as' => 'jobs.show', 'uses' => 'JobsController@show']);

    /*
     * Job Actions Routes
     */
    Route::get('jobs/{job}/edit', ['as' => 'jobs.edit', 'uses' => 'JobsController@edit']);
    Route::patch('jobs/{job}', ['as' => 'jobs.update', 'uses' => 'JobsController@update']);
    Route::get('jobs/{job}/delete', ['as' => 'jobs.delete', 'uses' => 'JobsController@delete']);
    Route::delete('jobs/{job}', ['as' => 'jobs.destroy', 'uses' => 'JobsController@destroy']);
    Route::post('jobs/{id}/tasks-reorder', ['as' => 'jobs.tasks-reorder', 'uses' => 'JobsController@tasksReorder']);

    /*
     * Project Comments Routes
     */
    Route::get('jobs/{job}/comments', 'Jobs\CommentsController@index')->name('jobs.comments.index');
    Route::post('jobs/{job}/comments', 'Jobs\CommentsController@store')->name('jobs.comments.store');
    Route::patch('jobs/{job}/comments/{comment}', 'Jobs\CommentsController@update')->name('jobs.comments.update');
    Route::delete('jobs/{job}/comments/{comment}', 'Jobs\CommentsController@destroy')->name('jobs.comments.destroy');
});

/*
 * Issue Options Routes
 */
Route::patch('issues/{issue}/options', 'Issues\OptionController@update')->name('issues.options.update');

/*
 * Issue Comments Routes
 */
Route::post('issues/{issue}/comments', 'Issues\CommentController@store')->name('issues.comments.store');
Route::patch('issues/{issue}/comments/{comment}', 'Issues\CommentController@update')->name('issues.comments.update');
Route::delete('issues/{issue}/comments/{comment}', 'Issues\CommentController@destroy')->name('issues.comments.destroy');
