<?php

namespace App\Entities\Projects;

use App\Entities\Users\User;
use App\Entities\Projects\Project;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = ['project_id', 'title', 'body', 'creator_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
