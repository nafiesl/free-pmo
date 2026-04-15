<?php

namespace App\Policies\Projects;

use App\Entities\Projects\File;
use App\Entities\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the file.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\File  $file
     * @return bool
     */
    public function view(User $user, File $file)
    {
        return true;
    }

    /**
     * Determine whether the user can create files.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\File  $file
     * @return bool
     */
    public function create(User $user, File $file)
    {
        return true;
    }

    /**
     * Determine whether the user can update the file.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\File  $file
     * @return bool
     */
    public function update(User $user, File $file)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the file.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\File  $file
     * @return bool
     */
    public function delete(User $user, File $file)
    {
        return true;
    }
}