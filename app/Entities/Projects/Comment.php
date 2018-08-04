<?php

namespace App\Entities\Projects;

use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'creator_id'];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
