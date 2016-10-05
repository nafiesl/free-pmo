<?php

namespace App\Entities\Projects;

use App\Entities\Payments\Payment;
use App\Entities\Projects\ProjectPresenter;
use App\Entities\Subscriptions\Subscription;
use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Project extends Model {

    use PresentableTrait;

    protected $presenter = ProjectPresenter::class;
    protected $guarded = ['id','created_at','updated_at'];
	// protected $dates = ['start_date','end_date'];

    public function features()
    {
        return $this->hasMany(Feature::class)->orderBy('position');
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

    public function payments()
    {
        return $this->hasMany(Payment::class)->orderBy('date','desc');
    }

    public function customer()
    {
        return $this->belongsTo(User::class,'customer_id');
    }

    public function cashInTotal()
    {
        return $this->payments->sum(function($payment) {
            return $payment->in_out == 1 ? $payment->amount : 0;
        });
    }

    public function cashOutTotal()
    {
        return $this->payments->sum(function($payment) {
            return $payment->in_out == 0 ? $payment->amount : 0;
        });
    }

    public function getFeatureOveralProgress()
    {
        $overalProgress = 0;
        $this->features->load('tasks');
        $totalPrice = $this->features->sum('price');

        foreach ($this->features as $feature) {
            $progress = $feature->tasks->avg('progress');
            $index = $feature->price / $totalPrice;
            $overalProgress += $progress * $index;
        }

        return $overalProgress;
    }

}
