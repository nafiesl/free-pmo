<?php

namespace App\Entities\Projects;

use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = [
        'project_id', 'title', 'body', 'priority_id', 'pic_id', 'creator_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function pic()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => __('issue.no_pic')]);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function getPriorityAttribute()
    {
        return Priority::getNameById($this->priority_id);
    }

    public function getPriorityLabelAttribute()
    {
        $classColor = Priority::getColorById($this->priority_id);

        return '<span class="label label-'.$classColor.'">'.$this->priority.'</span>';
    }

    public function getStatusAttribute()
    {
        return IssueStatus::getNameById($this->status_id);
    }

    public function getStatusLabelAttribute()
    {
        return '<span class="badge">'.$this->status.'</span>';
    }

    /**
     * Issue has many comments relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
