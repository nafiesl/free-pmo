<?php

namespace App\Entities\Users;

use Illuminate\Database\Eloquent\Model;

/**
 * User Role model.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class UserRole extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_roles';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'role_id'];

    /**
     * Role name attribute.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return Role::getNameById($this->role_id);
    }
}
