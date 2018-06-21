<?php

namespace App\Entities\Projects;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $touches = ['job'];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
