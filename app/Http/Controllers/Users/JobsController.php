<?php

namespace App\Http\Controllers\Users;

use App\Entities\Users\User;
use App\Http\Controllers\Controller;

/**
 * User Jobs Controller.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class JobsController extends Controller
{
    public function index(User $user)
    {
        $jobs = $user->jobs()->whereHas('tasks', function ($query) {
            return $query->where('progress', '<', 100);
        })->whereHas('project', function ($query) {
            return $query->whereIn('status_id', [2, 3]);
        })->where('worker_id', $user->id)
            ->with(['tasks', 'project'])
            ->paginate();

        return view('users.jobs', compact('user', 'jobs'));
    }
}
