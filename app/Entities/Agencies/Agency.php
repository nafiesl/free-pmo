<?php

namespace App\Entities\Agencies;

use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;

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

    public function addWorker(User $worker)
    {
        $this->workers()->attach($worker);
    }

    public function removeWorker(User $worker)
    {
        $this->workers()->detach($worker);
    }
}
