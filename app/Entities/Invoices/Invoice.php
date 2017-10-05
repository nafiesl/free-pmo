<?php

namespace App\Entities\Invoices;

use App\Entities\Projects\Project;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = ['id','created_at','updated_at'];

    protected $casts = ['items' => 'array'];

    public function getRouteKeyName()
    {
        return 'number';
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
