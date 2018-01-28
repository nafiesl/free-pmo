<?php

namespace App\Entities\Partners;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'pic', 'address', 'website', 'notes', 'is_active'];

    public function projects()
    {
        return $this->hasMany('App\Entities\Projects\Project');
    }

    public function payments()
    {
        return $this->hasMany('App\Entities\Payments\Payment', 'partner_id');
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Entities\Subscriptions\Subscription');
    }

    public function nameLink()
    {
        return link_to_route('customers.show', $this->name, [$this->id], [
            'title' => trans(
                'app.show_detail_title',
                ['name' => $this->name, 'type' => trans('customer.customer')]
            ),
        ]);
    }
}
