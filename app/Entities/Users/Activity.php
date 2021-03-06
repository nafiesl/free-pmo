<?php

namespace App\Entities\Users;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'user_activities';

    protected $fillable = ['type', 'parent_id', 'user_id', 'object_id', 'object_type', 'data'];

    protected $casts = [
        'data' => 'array',
    ];
}
