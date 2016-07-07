<?php

namespace App\Entities\References;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model {

    protected $fillable = ['cat','code','name'];
    protected $table = 'references';
	public $timestamps = false;
}
