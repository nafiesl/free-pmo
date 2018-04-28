<?php

namespace App\Entities\Partners;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['name', 'notes', 'website', 'is_active'];

    public function payments()
    {
        return $this->hasMany('App\Entities\Payments\Payment', 'partner_id');
    }
}
