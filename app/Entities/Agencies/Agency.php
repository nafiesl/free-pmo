<?php

namespace App\Entities\Agencies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Agency extends Model
{
    protected $fillable = ['name', 'email', 'address', 'phone', 'website', 'owner_id'];

    public function owner()
    {
        return $this->belongsTo('App\Entities\Users\User');
    }

    public function projects()
    {
        return $this->hasMany('App\Entities\Projects\Project', 'owner_id');
    }

    public function workers()
    {
        return $this->belongsToMany('App\Entities\Users\User', 'agency_workers', 'agency_id', 'worker_id');
    }

    public function addWorkers(Collection $workers)
    {
        $this->workers()->attach($workers);
    }

    public function removeWorkers(Collection $workers)
    {
        $this->workers()->detach($workers);
    }
}
