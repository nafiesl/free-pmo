<?php

namespace App\Entities\Invoices;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'number', 'account_name', 'description', 'is_active',
    ];

    /**
     * Get status attribute.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->is_active == 1 ? __('app.active') : __('app.in_active');
    }
}
