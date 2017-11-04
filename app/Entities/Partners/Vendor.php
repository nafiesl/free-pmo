<?php

namespace App\Entities\Partners;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['name', 'notes', 'website', 'is_active'];
}
