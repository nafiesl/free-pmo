<?php

namespace App\Http\Controllers\Users;

use App\Entities\Users\User;
use App\Http\Controllers\Controller;
use App\Queries\AdminDashboardQuery;

/**
 * User Jobs Controller.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class JobsController extends Controller
{
    public function index(User $user)
    {
        $jobs = (new AdminDashboardQuery)->onProgressJobs($user);

        return view('users.jobs', compact('user', 'jobs'));
    }
}
