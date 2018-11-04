<?php

namespace App\Entities\Options;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'value'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'site_options';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
