<?php

namespace App\Entities\Users;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles_permissions';

	protected $fillable = ['type','name','label'];
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
