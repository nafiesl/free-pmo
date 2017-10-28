<?php

namespace App\Entities\Projects;

use App\Entities\Invoices\Invoice;
use App\Entities\Partners\Partner;
use App\Entities\Payments\Payment;
use App\Entities\Projects\ProjectPresenter;
use App\Entities\Projects\Task;
use App\Entities\Subscriptions\Subscription;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Project extends Model
{

    use PresentableTrait;

    protected $presenter = ProjectPresenter::class;
    protected $guarded   = ['id', 'created_at', 'updated_at'];
    // protected $dates = ['start_date','end_date'];

    public function nameLink()
    {
        return link_to_route('projects.show', $this->name, [$this->id]);
    }

    public function features()
    {
        return $this->hasMany(Feature::class)->orderBy('position');
    }

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, Feature::class);
    }

    public function mainFeatures()
    {
        return $this->hasMany(Feature::class)->orderBy('position')->whereTypeId(1);
    }

    public function additionalFeatures()
    {
        return $this->hasMany(Feature::class)->orderBy('position')->whereTypeId(2);
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
        return $this->belongsTo(Partner::class);
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

    public function getFeatureOveralProgress()
    {
        $overalProgress = 0;
        $this->load('features.tasks');
        $totalPrice = $this->features->sum('price');

        foreach ($this->features as $feature) {
            $progress = $feature->tasks->avg('progress');
            $index    = $totalPrice ? ($feature->price / $totalPrice) : 1;
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
        // Collectible earnings is total of (price * avg task progress of each feature)
        $collectibeEarnings = 0;
        $this->load('features.tasks');

        foreach ($this->features as $feature) {
            $progress = $feature->tasks->avg('progress');
            $collectibeEarnings += ($progress / 100) * $feature->price;
        }

        return $collectibeEarnings;
    }

}
