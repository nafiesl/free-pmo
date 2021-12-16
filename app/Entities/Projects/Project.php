<?php

namespace App\Entities\Projects;

use App\Entities\Invoices\Invoice;
use App\Entities\Partners\Customer;
use App\Entities\Payments\Payment;
use App\Entities\Subscriptions\Subscription;
use DB;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

/**
 * Project Model.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class Project extends Model
{
    use PresentableTrait;
    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => 'App\Events\Projects\Created',
        'updated' => 'App\Events\Projects\Updated',
    ];

    /**
     * @var \App\Entities\Projects\ProjectPresenter
     */
    protected $presenter = ProjectPresenter::class;

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Show project name with link to project detail.
     *
     * @return Illuminate\Support\HtmlString
     */
    public function nameLink()
    {
        return link_to_route('projects.show', $this->name, [$this], [
            'title' => __(
                'app.show_detail_title',
                ['name' => $this->name, 'type' => __('project.project')]
            ),
        ]);
    }

    /**
     * Project has many Jobs relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobs()
    {
        return $this->hasMany(Job::class)->orderBy('position');
    }

    /**
     * Project has many Tasks relation through Job model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function tasks()
    {
        return $this->hasManyThrough(Task::class, Job::class);
    }

    /**
     * Project has many main Jobs relation (based on job_type_id).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mainJobs()
    {
        return $this->hasMany(Job::class)->orderBy('position')->whereTypeId(1);
    }

    /**
     * Project has many additioanl Jobs relation (based on job_type_id).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function additionalJobs()
    {
        return $this->hasMany(Job::class)->orderBy('position')->whereTypeId(2);
    }

    /**
     * Project has many Subscriptions relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Project has many Invoices relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Project has many Payments relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class)->orderBy('date', 'desc');
    }

    /**
     * Project has many Comments relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Project belongs to a Customer relation.
     *
     * @return \Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Project cash in (income) total.
     *
     * @return int
     */
    public function cashInTotal()
    {
        return $this->payments->sum(function ($payment) {
            return $payment->in_out == 1 ? $payment->amount : 0;
        });
    }

    /**
     * Project cash out (spending) total.
     *
     * @return int
     */
    public function cashOutTotal()
    {
        return $this->payments->sum(function ($payment) {
            return $payment->in_out == 0 ? $payment->amount : 0;
        });
    }

    /**
     * Get project overal job progress in percent.
     *
     * @return float
     */
    public function getJobOveralProgress()
    {
        $overalProgress = 0;
        $this->load('jobs.tasks');
        $totalPrice = $this->jobs->sum('price');

        if ($totalPrice == 0) {
            return $this->jobs->avg('progress');
        }

        foreach ($this->jobs as $job) {
            $index = $job->price / $totalPrice;
            $overalProgress += $job->progress * $index;
        }

        return $overalProgress;
    }

    /**
     * Project has many Files relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * Get project collectible earnings, based on job progress.
     *
     * @return float
     */
    public function getCollectibeEarnings()
    {
        // Collectible earnings is total of (price * avg task progress of each job)
        $collectibeEarnings = 0;
        $this->load('jobs.tasks');

        foreach ($this->jobs as $job) {
            $progress = $job->tasks->avg('progress');
            $collectibeEarnings += ($progress / 100) * $job->price;
        }

        return $collectibeEarnings;
    }

    /**
     * Get project job list based on job tipe.
     *
     * @param  string  $jobType
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getJobList($jobType)
    {
        $jobType = (int) $jobType;

        return $this->jobs()->where('type_id', $jobType)
            ->orderBy('position')
            ->with('worker', 'tasks')
            ->get();
    }

    public function getWorkDurationAttribute()
    {
        $startDate = $this->start_date;
        $endDate = $this->end_date;

        if (is_null($endDate)) {
            return '-';
        }

        $workDuration = date_difference($startDate, $endDate);

        if ((int) $workDuration > 365) {
            return date_difference($startDate, $endDate, '%y Year(s) %m Month(s)');
        } elseif ((int) $workDuration > 30) {
            return date_difference($startDate, $endDate, '%m Month(s) %d Day(s)');
        }

        return $workDuration.' Day(s)';
    }

    /**
     * Delete the model from the database.
     *
     * @return bool|null
     */
    public function delete()
    {
        DB::beginTransaction();
        $this->jobs->each->delete();
        $this->files->each->delete();
        $this->invoices()->delete();
        $this->payments()->delete();
        $this->subscriptions()->delete();
        $this->comments()->delete();
        DB::commit();

        return parent::delete();
    }

    /**
     * Project has many Issues relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
