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
        $string = $this->username . ' (';
        foreach($this->roles as $key => $role) {
            $string .= ($key != 0) ? ' | ' : '';
            $string .= $role->label;
        }
        $string .= ')';

        return $string;
    }

    public function displayPermissions()
    {
        $string = '<ul class="permissions-list">';
        foreach($this->roles as $key => $role) {
            foreach ($role->permissions as $key2 => $permission) {
                $string .= '<li>' . $permission->label . '</li>';
            }
        }
        $string .= '</ul>';

        return $string;
    }

    public function photo()
    {
        return Html::image('assets/imgs/icon_user_1.png', $this->name, ['width' => '100px']);
    }

}