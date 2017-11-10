<?php

namespace App\Entities\Subscriptions;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Subscription extends Model
{
    use PresentableTrait;

    protected $presenter = 'App\Entities\Subscriptions\SubscriptionPresenter';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function nameLink()
    {
        return link_to_route('subscriptions.show', $this->name, [$this->id], [
            'title' => trans(
                'app.show_detail_title',
                ['name' => $this->name, 'type' => trans('subscription.subscription')]
            ),
        ]);
    }

    public function nearOfDueDate()
    {
        return Carbon::parse($this->due_date)->diffInDays(Carbon::now()) < 60;
    }

    public function nearOfDueDateSign()
    {
        return $this->nearOfDueDate() ? '<i class="fa fa-exclamation-circle" style="color: red"></i>' : '';
    }

    public function dueDateDescription()
    {
        $dueDateDescription = trans('subscription.start_date').' : '.dateId($this->start_date)."\n";
        $dueDateDescription .= trans('subscription.due_date').' : '.dateId($this->due_date);

        return $dueDateDescription;
    }

    public function project()
    {
        return $this->belongsTo('App\Entities\Projects\Project');
    }

    public function customer()
    {
        return $this->belongsTo('App\Entities\Partners\Customer');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Entities\Partners\Vendor');
    }

    public function status()
    {
        return $this->status_id == 1 ? trans('app.active') : trans('app.in_active');
    }

    public function getTypeAttribute()
    {
        return Type::getNameById($this->type_id);
    }

    public function getTypeColorAttribute()
    {
        return Type::getColorById($this->type_id);
    }
}
