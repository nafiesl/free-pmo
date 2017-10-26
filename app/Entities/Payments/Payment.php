<?php

namespace App\Entities\Payments;

use App\Entities\Payments\PaymentPresenter;
use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Payment extends Model
{

    use PresentableTrait;

    protected $presenter = PaymentPresenter::class;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function type()
    {
        return paymentTypes($this->type_id);
    }
}
