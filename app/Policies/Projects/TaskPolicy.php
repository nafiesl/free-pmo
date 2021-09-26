<?php

namespace App\Policies\Projects;

use App\Entities\Projects\Task;
use App\Entities\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create tasks.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Task  $task
     * @return mixed
     */
    public function create(User $user, Task $task)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the task.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Task  $task
     * @return mixed
     */
    public function update(User $user, Task $task)
    {
        return $user->hasRole('admin')
            || ($user->hasRole('worker') && $task->job->worker_id == $user->id);
    }

    /**
     * Determine whether the user can delete the task.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Entities\Projects\Task  $task
     * @return mixed
     */
    public function delete(User $user, Task $task)
    {
        return $user->hasRole('admin');
    }
}
