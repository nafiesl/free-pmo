<?php

namespace App\Entities\Projects;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = ['project_id', 'title', 'body', 'creator_id'];
}
