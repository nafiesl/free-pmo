<?php

namespace App\Entities\Options;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {

    protected $fillable = ['key','value'];
    protected $table = 'site_options';
	public $timestamps = false;
}
