<?php

namespace App\Entities\Users;

use App\Entities\Users\UserPresenter;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;

class User extends Authenticatable
{
    use Notifiable, PresentableTrait;

    protected $fillable  = ['name', 'email', 'password'];
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

    /**
     * A user may have multiple roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Assign the given role to the user.
     *
     * @param  string $role
     * @return mixed
     */
    public function assignRole($roleName)
    {
        $role = Role::firstOrNew(['name' => $roleName]);

        if ($role->exists == false) {
            $role->label = ucwords($roleName);
            $role->save();
        }

        return $this->roles()->attach($role);
    }

    /**
     * Remove the given role from the user.
     *
     * @param  string $role
     * @return mixed
     */
    public function removeRole($role)
    {
        $roleId = Role::whereName($role)->firstOrFail()->id;
        return $this->roles()->detach($roleId);
    }

    /**
     * Determine if the user has the given role.
     *
     * @param  mixed $role
     * @return boolean
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return  !  ! $role->intersect($this->roles)->count();
    }

    public function hasRoles(array $roleNameArray)
    {
        return $this->roles->pluck('name')
            ->contains(function ($role, $key) use ($roleNameArray) {
                return in_array($role, $roleNameArray);
            });
    }

    public function scopeHasRoles($query, array $roleNameArray)
    {
        return $query->whereHas('roles', function ($q) use ($roleNameArray) {
            $q->whereIn('name', $roleNameArray);
        });
    }
}
