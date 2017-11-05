<?php

namespace App\Entities\Users;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'api_token'];
    protected $hidden   = ['password', 'remember_token', 'api_token'];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function nameLink()
    {
        return link_to_route('users.show', $this->name, [$this->id], ['target' => '_blank']);
    }
}
