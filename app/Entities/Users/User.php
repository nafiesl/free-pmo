<?php

namespace App\Entities\Users;

use App\Entities\Users\UserPresenter;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laracasts\Presenter\PresentableTrait;

class User extends Authenticatable
{
    use PresentableTrait, HasRoles;

    protected $fillable = ['name', 'username', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $presenter = UserPresenter::class;

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
