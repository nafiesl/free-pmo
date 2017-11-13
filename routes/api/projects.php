<?php

Route::resource('projects', 'ProjectsController');
Route::get('projects/{project}/jobs', ['as' => 'projects.jobs', 'uses' => 'ProjectsController@jobs']);
