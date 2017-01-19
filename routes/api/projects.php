<?php

Route::resource('projects', 'ProjectsController');
Route::get('projects/{project}/features', ['as' => 'projects.features', 'uses' => 'ProjectsController@features']);