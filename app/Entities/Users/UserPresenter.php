<?php

namespace App\Entities\Users;

use Html;
use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
    public function displayRoles()
    {
        $string = '';
        foreach($this->roles as $key => $role) {
            $string .= ($key != 0) ? ' | ' : '';
            $string .= $role->label;
        }

        return $string;
    }

    public function rolesLink()
    {
        $string = '';
        foreach($this->roles as $key => $role) {
            $string .= ($key != 0) ? ' | ' : '';
            $string .= link_to_route('users.index', $role->label, ['role' => $role->name], ['title' => 'Lihat semua ' . $role->label]);
        }

        return $string;
    }

    public function usernameRoles()
    {
        $string = $this->name . ' (';
        foreach($this->roles as $key => $role) {
            $string .= ($key != 0) ? ' | ' : '';
            $string .= $role->label;
        }
        $string .= ')';

        return $string;
    }
}