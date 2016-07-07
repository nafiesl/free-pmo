<?php

namespace App\Entities\Users;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'roles_permissions';

    protected $fillable = ['type','name','label'];
    public $timestamps = false;

    /**
     * A permission can be applied to roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role_permission');
    }
}
