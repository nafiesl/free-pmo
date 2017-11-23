<?php

namespace App\Entities\Projects;

use App\Entities\Invoices\Invoice;
use App\Entities\Partners\Customer;
use App\Entities\Payments\Payment;
use App\Entities\Projects\ProjectPresenter;
use App\Entities\Projects\Task;
use App\Entities\Subscriptions\Subscription;
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

    protected $presenter = ProjectPresenter::class;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    // protected $dates = ['start_date','end_date'];

    public function nameLink()
    {
        return link_to_route('projects.show', $this->name, [$this->id], [
            'title' => trans(
                'app.show_detail_title',
                ['name' => $this->name, 'type' => trans('project.project')]
            ),
        ]);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class)->orderBy('position');
    }

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, Job::class);
    }

    public function mainJobs()
    {
        return $this->hasMany(Job::class)->orderBy('position')->whereTypeId(1);
    }

    public function additionalJobs()
    {
        return $this->hasMany(Job::class)->orderBy('position')->whereTypeId(2);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class)->orderBy('date', 'desc');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function cashInTotal()
    {
        return $this->payments->sum(function ($payment) {
            return $payment->in_out == 1 ? $payment->amount : 0;
        });
    }

    public function cashOutTotal()
    {
        return $this->payments->sum(function ($payment) {
            return $payment->in_out == 0 ? $payment->amount : 0;
        });
    }

    public function getJobOveralProgress()
    {
        $overalProgress = 0;
        $this->load('jobs.tasks');
        $totalPrice = $this->jobs->sum('price');

        foreach ($this->jobs as $job) {
            $progress = $job->tasks->avg('progress');
            $index = $totalPrice ? ($job->price / $totalPrice) : 1;
            $overalProgress += $progress * $index;
        }

        return $overalProgress;
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

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

    public function getJobList($jobType)
    {
        $jobType = (int) $jobType;

        return $this->jobs()->where('type_id', $jobType)
            ->orderBy('position')
            ->with('worker', 'tasks')
            ->get();
    }

}
