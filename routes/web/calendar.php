<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Api'], function () {
    /*
     * Savety Calendar
     */
    Route::get('my-calendar', ['as' => 'users.calendar', 'uses' => function () {
        $user = auth()->user();

        if ($user->hasRole('admin') == false) {
            $projects = $user->projects()->orderBy('projects.name')->pluck('projects.name', 'projects.id');
        } else {
            $projects = App\Entities\Projects\Project::orderBy('name')->pluck('name', 'id');
        }

        return view('users.calendar', compact('projects'));
    }]);
});
