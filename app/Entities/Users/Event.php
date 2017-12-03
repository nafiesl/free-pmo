<?php

namespace App\Entities\Users;

use App\Entities\Projects\Project;
use Illuminate\Database\Eloquent\Model;

/**
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class Event extends Model
{
    protected $table = 'user_events';
    protected $guarded = ['id', 'created_at', 'updated_at'];
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
