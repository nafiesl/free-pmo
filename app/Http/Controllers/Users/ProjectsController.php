<?php

namespace App\Http\Controllers\Users;

use App\Entities\Users\User;
use App\Http\Controllers\Controller;

/**
 * User Projects Controller.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class ProjectsController extends Controller
{
    public function index(User $user)
    {
        $projects = $user->projects()
            ->where(function ($query) {
                $query->where('projects.name', 'like', '%'.request('q').'%');
                $query->where('status_id', request('status', 2));
            })
            ->latest()
            ->with(['customer'])
            ->paginate();

        return view('users.projects', compact('user', 'projects'));
    }
}
