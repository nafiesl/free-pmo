<?php

namespace App\Entities\Users;

use App\Entities\Users\UserPresenter;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;

class User extends Authenticatable
{
    use Notifiable, PresentableTrait;

    protected $fillable  = ['name', 'email', 'password', 'api_token'];
    protected $hidden    = ['password', 'remember_token', 'api_token'];
    protected $presenter = UserPresenter::class;

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function nameLink()
    {
        return link_to_route('users.show', $this->name, [$this->id], ['target' => '_blank']);
    }

    public function agency()
    {
        return $this->hasOne('App\Entities\Agencies\Agency', 'owner_id');
    }
}
