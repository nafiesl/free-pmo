<?php

namespace App\Entities\Subscriptions;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Subscription extends Model
{
    use PresentableTrait;

    protected $presenter = 'App\Entities\Subscriptions\SubscriptionPresenter';
    protected $guarded   = ['id', 'created_at', 'updated_at'];

    public function project()
    {
        return $this->belongsTo('App\Entities\Projects\Project');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Entities\Partners\Partner');
    }

    public function status()
    {
        return $this->status_id ? trans('app.active') : trans('app.in_active');
    }
}
