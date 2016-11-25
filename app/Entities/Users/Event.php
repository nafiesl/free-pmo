<?php

namespace App\Entities\Users;

use App\Entities\Findings\Finding;
use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Event extends Model
{
    protected $table = 'user_events';
    protected $guarded = ['id','created_at','updated_at'];
    protected $casts = ['is_allday' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
