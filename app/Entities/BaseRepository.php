<?php

namespace App\Entities;

use App\Entities\Projects\Project;
use App\Entities\Users\User;

/**
* Base Repository Class
*/
abstract class BaseRepository extends EloquentRepository {

    public function getCustomersList()
    {
        return User::orderBy('name')->hasRoles(['customer'])->lists('name','id');
    }

    public function getWorkersList()
    {
        return User::orderBy('name')->hasRoles(['worker'])->lists('name','id');
    }

    public function getProjectsList()
    {
        return Project::orderBy('name')->lists('name','id');
    }
}