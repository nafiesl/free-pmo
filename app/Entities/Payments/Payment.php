<?php

namespace App\Entities\Payments;

use App\Entities\Partners\Partner;
use App\Entities\Payments\PaymentPresenter;
use App\Entities\Projects\Project;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Payment extends Model
{
    use PresentableTrait;

    protected $presenter = PaymentPresenter::class;
    protected $guarded   = ['id', 'created_at', 'updated_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function type()
    {
        return paymentTypes($this->type_id);
    }
}
