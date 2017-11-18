<?php

namespace App\Entities\Users;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class UserRole extends Model
{
    protected $table = 'user_roles';
    public $timestamps = false;
    protected $appends = ['name'];
    protected $fillable = ['user_id', 'role_id'];

    public function getNameAttribute()
    {
        return Role::getNameById($this->role_id);
    }
}
