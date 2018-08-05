<?php

namespace App\Policies\Projects;

use App\Entities\Users\User;
use App\Entities\Projects\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Comment model policy class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the comment.
     *
     * @param \App\Entities\Users\User  $user
     * @param \App\Entities\Projects\Comment  $comment
     * @return bool
     */
    public function update(User $user, Comment $comment)
    {
        return $user->hasRole('admin')
            || ($user->hasRole('worker') && $comment->creator_id == $user->id);
    }
}
