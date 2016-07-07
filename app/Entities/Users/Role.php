<?php

namespace App\Entities\Users;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles_permissions';

	protected $fillable = ['type','name','label'];
    public $timestamps = false;

    /**
     * A role may be given various permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_role_permission');
    }

    /**
     * Grant the given permission to a role.
     *
     * @param  Permission $permission
     * @return mixed
     */
    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
