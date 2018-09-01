<?php

namespace App\Entities\Users;

use App\Entities\Projects\Project;
use Illuminate\Database\Eloquent\Model;

/**
 * User event model.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class Event extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_events';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['is_allday' => 'boolean'];

    /**
     * Event belongs to User relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Event belongs to Project relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
