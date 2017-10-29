<?php

namespace App\Policies;

use App\Entities\Agencies\Agency;
use App\Entities\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgencyPolicy
{
    use HandlesAuthorization;

    public function manage(User $user, Agency $agency)
    {
        return $user->id == $agency->owner_id;
    }
}
