<?php

namespace App\Entities\Projects;

use App\Entities\Users\User;
use DB;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

/**
 * Job Model.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class Job extends Model
{
    use PresentableTrait;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => 'App\Events\Jobs\Created',
        'updated' => 'App\Events\Jobs\Updated',
        'deleted' => 'App\Events\Jobs\Deleted',
    ];

    /**
     * @var \App\Entities\Projects\JobPresenter
     */
    protected $presenter = JobPresenter::class;

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Show job name with link to job detail.
     *
     * @return Illuminate\Support\HtmlString
     */
    public function nameLink()
    {
        return link_to_route('jobs.show', $this->name, [$this->id], [
            'title' => __(
                'app.show_detail_title',
                ['name' => $this->name, 'type' => __('job.job')]
            ),
        ]);
    }

    /**
     * Job belongs to a Project relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Job belongs to a Worker relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    /**
     * Job has many Tasks relation ordered by position.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('position');
    }

    /**
     * Job has many comments relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get the job type.
     *
     * @return string
     */
    public function type()
    {
        return $this->type_id == 1 ? __('job.main') : __('job.additional');
    }

    /**
     * Add progress attribute on Job model.
     *
     * @return int
     */
    public function getProgressAttribute()
    {
        return $this->tasks->isEmpty() ? 0 : $this->tasks->avg('progress');
    }

    /**
     * Add receiveable_earning attribute on Job model.
     *
     * @return float
     */
    public function getReceiveableEarningAttribute()
    {
        return $this->price * ($this->progress / 100);
    }

    /**
     * Delete the model from the database.
     *
     * @return bool|null
     */
    public function delete()
    {
        DB::beginTransaction();
        $this->tasks()->delete();
        $this->comments()->delete();
        DB::commit();

        return parent::delete();
    }
}
