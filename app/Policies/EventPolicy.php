<?php

namespace App\Policies;

use App\Entities\Users\Event;
use App\Entities\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Event model policy class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class EventPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Event $event)
    {
        return $user->id == $event->user_id;
    }

    public function delete(User $user, Event $event)
    {
        return $user->id == $event->user_id;
    }
}
