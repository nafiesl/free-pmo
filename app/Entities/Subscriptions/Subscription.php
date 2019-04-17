<?php

namespace App\Entities\Subscriptions;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Subscription Model.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class Subscription extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Show subscription name with link to subscription detail attribute.
     *
     * @return Illuminate\Support\HtmlString
     */
    public function getNameLinkAttribute()
    {
        return link_to_route('subscriptions.show', $this->name, $this, [
            'title' => __(
                'app.show_detail_title',
                ['name' => $this->name, 'type' => __('subscription.subscription')]
            ),
        ]);
    }

    /**
     * Check weather the subscription is near it's due date.
     *
     * @return bool
     */
    public function nearOfDueDate()
    {
        return Carbon::parse($this->due_date)->diffInDays(Carbon::now()) < 60;
    }

    /**
     * Show the subscription near due date sign (icon).
     *
     * @return string
     */
    public function nearOfDueDateSign()
    {
        return $this->nearOfDueDate() ? '<i class="fa fa-exclamation-circle" style="color: red"></i>' : '';
    }

    /**
     * Subscription near due date description.
     *
     * @return string
     */
    public function dueDateDescription()
    {
        $dueDateDescription = __('subscription.start_date').' : '.date_id($this->start_date)."\n";
        $dueDateDescription .= __('subscription.due_date').' : '.date_id($this->due_date);

        return $dueDateDescription;
    }

    /**
     * Subscription belongs to Project relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Entities\Projects\Project');
    }

    /**
     * Subscription belongs to Customer relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo('App\Entities\Partners\Customer');
    }

    /**
     * Subscription belongs to Vendor relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor()
    {
        return $this->belongsTo('App\Entities\Partners\Vendor');
    }

    /**
     * Get subscription status to display in the view.
     *
     * @return string
     */
    public function status()
    {
        return $this->status_id == 1 ? __('app.active') : __('app.in_active');
    }

    /**
     * Add type attribute on Subscription model.
     *
     * @return string
     */
    public function getTypeAttribute()
    {
        return Type::getNameById($this->type_id);
    }

    /**
     * Add type_color attribute on Subscription model.
     *
     * @return string
     */
    public function getTypeColorAttribute()
    {
        return Type::getColorById($this->type_id);
    }

    /**
     * Add type_label attribute on Subscription model.
     *
     * @return string
     */
    public function getTypeLabelAttribute()
    {
        return '<span class="badge" style="background-color: '.$this->type_color.'">'.$this->type.'</span>';
    }
}
