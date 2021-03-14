<?php

namespace App\Entities\Projects;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => 'App\Events\Tasks\Created',
        'updated' => 'App\Events\Tasks\Updated',
        'deleted' => 'App\Events\Tasks\Deleted',
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $touches = ['job'];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
