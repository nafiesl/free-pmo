<?php
namespace App\Entities\Users;

use App\Entities\BaseRepository;
use App\Exceptions\UpdateUserException;
use App\Exceptions\UserDeleteException;
use App\Exceptions\UserNotFoundException;
use App\Services\Facades\Option;

/**
* Users Repository Class
*/
class UsersRepository extends BaseRepository
{

    protected $model;

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getUsers($q, $rolesString)
    {
        return $this->model->latest()
        ->where('name','like','%'.$q.'%')
        ->whereHas('roles', function($query) use ($rolesString) {
            if (!is_null($rolesString)) {
                $query->whereIn('name', explode('|', $rolesString));
            }
        })
        ->with('roles')
        ->paginate($this->_paginate);
    }

    public function create($userData)
    {
        if ($userData['password'] == '')
            $userData['password'] = Option::get('password_default','member');

        $user = $this->storeArray($userData);
        $user->roles()->sync($userData['role']);

        return $user;
    }

    public function update($userData, $userId)
    {
        $user = $this->requireById($userId);

        foreach ($userData as $key => $value) {
            if ($value == '' || $key == 'role') continue;
            $user->{$key} = $value;
        }

        $user->roles()->sync($userData['role']);

        if ($user->save())
            return $user;

        throw new UpdateUserException('Failed to update User');
    }

    public function getRolesList()
    {
        return Role::where('type', 0)->pluck('label','id')->all();
    }

    public function delete($userId)
    {
        $user = $this->requireById($userId);
        $user->roles()->detach();

        return $user->delete();
    }
}