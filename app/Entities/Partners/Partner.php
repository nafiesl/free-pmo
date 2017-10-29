<?php

namespace App\Entities\Partners;

use App\Traits\OwnedByAgency;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use OwnedByAgency;

    protected $fillable = ['name', 'email', 'phone', 'pic', 'address', 'notes', 'is_active', 'owner_id'];

    public function owner()
    {
        return $this->belongsTo('App\Entities\Agencies\Agency');
    }

    public function projects()
    {
        return $this->hasMany('App\Entities\Projects\Project', 'customer_id');
    }
}
