<?php

Route::group(['middleware' => ['web','auth'], 'namespace' => 'Api'], function() {
    /**
     * Savety Calendar
     */
    Route::get('my-calendar', ['as' => 'users.calendar', 'uses' => function() {
        $projects = App\Entities\Projects\Project::orderBy('name')->pluck('name', 'id');
        return view('users.calendar', compact('projects'));
    }]);
});