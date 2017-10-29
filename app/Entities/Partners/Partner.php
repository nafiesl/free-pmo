<?php

namespace App\Entities\Partners;

use App\Traits\OwnedByAgency;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use OwnedByAgency;

    protected $fillable = ['name', 'type_id', 'email', 'phone', 'pic', 'address', 'notes', 'is_active', 'owner_id'];

    public function getTypeAttribute()
    {
        return $this->type_id == 1 ? trans('partner.types.customer') : trans('partner.types.vendor');
    }

    public function owner()
    {
        return $this->belongsTo('App\Entities\Agencies\Agency');
    }

    public function projects()
    {
        return $this->hasMany('App\Entities\Projects\Project', 'customer_id');
    }

    public function nameLink()
    {
        return link_to_route('partners.show', $this->name, [$this->id], [
            'title' => trans(
                'app.show_detail_title',
                ['name' => $this->name, 'type' => trans('partner.partner')]
            ),
        ]);
    }
}
