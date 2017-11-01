<?php

namespace App\Entities\Partners;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['name', 'description', 'owner_id'];

    public function owner()
    {
        return $this->belongsTo('App\Entities\Agencies\Agency', 'owner_id');
    }
}
