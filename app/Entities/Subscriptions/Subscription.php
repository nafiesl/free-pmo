<?php

namespace App\Entities\Subscriptions;

use App\Entities\Projects\Project;
use App\Entities\Subscriptions\SubscriptionPresenter;
use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Subscription extends Model {

    use PresentableTrait;

    protected $presenter = SubscriptionPresenter::class;
	protected $guarded = ['id','created_at','updated_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class,'customer_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class,'vendor_id');
    }

    public function status()
    {
        return $this->status_id ? 'Aktif' : 'Non Aktif';
    }

}
