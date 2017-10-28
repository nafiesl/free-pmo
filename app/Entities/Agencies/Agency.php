<?php

namespace App\Entities\Agencies;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable = ['name', 'email', 'address', 'phone', 'website', 'owner_id'];

    public function owner()
    {
        return $this->belongsTo('App\Entities\Users\User');
    }
}
