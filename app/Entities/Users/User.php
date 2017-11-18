<?php

namespace App\Entities\Users;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'api_token'];
    protected $hidden = ['password', 'remember_token', 'api_token'];

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
        return $this->hasMany(UserRole::class);
    }

    /**
     * Assign the given role to the user.
     *
     * @param  string $role
     * @return void
     */
    public function assignRole(string $roleName)
    {
        $roleId = Role::getIdByName($roleName);

        UserRole::create([
            'user_id' => $this->id,
            'role_id' => $roleId,
        ]);
    }

    /**
     * Remove the given role from the user.
     *
     * @param  string $role
     * @return void
     */
    public function removeRole(string $roleName)
    {
        $roleId = Role::getIdByName($roleName);

        \DB::table('user_roles')->where([
            'user_id' => $this->id,
            'role_id' => $roleId,
        ])->delete();
    }

    /**
     * Determine if the user has the given role.
     *
     * @param  string $role
     * @return boolean
     */
    public function hasRole(string $roleName)
    {
        $roleId = Role::getIdByName($roleName);

        return $this->roles->contains('role_id', $roleId);
    }

    /**
     * Determine if the user has the given array of role.
     *
     * @param  array $role
     * @return boolean
     */
    public function hasRoles(array $roleNameArray)
    {
        return $this->roles->pluck('role_id')
            ->contains(function ($roleId, $key) use ($roleNameArray) {
                $roleIds = [];

                foreach ($roleNameArray as $roleName) {
                    $roleIds[] = Role::getIdByName($roleName);
                }

                return in_array($roleId, $roleIds);
            });
    }

    public function scopeHasRoles($query, array $roleNameArray)
    {
        return $query->whereHas('roles', function ($q) use ($roleNameArray) {
            $roleIds = [];

            foreach ($roleNameArray as $roleName) {
                $roleIds[] = Role::getIdByName($roleName);
            }

            $q->whereIn('role_id', $roleIds);
        });
    }

    public function roleList()
    {
        $roleList = '<ul>';
        foreach ($this->roles as $role) {
            $roleList .= '<li>'.$role->name.'</li>';
        }
        $roleList .= '</ul>';

        return $roleList;
    }
}
