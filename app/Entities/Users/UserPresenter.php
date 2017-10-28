<?php

namespace App\Entities\Users;

use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
    public function displayRoles()
    {
        $string = '';

        return $string;
    }

    public function rolesLink()
    {
        $string = '';

        return $string;
    }

    public function usernameRoles()
    {
        $string = $this->name.' (';
        $string .= ')';

        return $string;
    }
}
