<?php

namespace App\Policies\Projects;

use App\Entities\Users\User;
use App\Entities\Projects\Issue;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssuePolicy
{
    use HandlesAuthorization;

    public function create(User $user, Issue $issue)
    {
        return true;
    }
}
