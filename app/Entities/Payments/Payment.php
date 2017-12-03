<?php

namespace App\Entities\Payments;

use App\Entities\Projects\Project;
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

    public function partner()
    {
        return $this->morphTo();
    }

    public function type()
    {
        $type = Type::getNameById($this->type_id);

        if ($this->in_out == 0 && $this->partner_type == 'App\Entities\Users\User') {
            $type .= ' Fee';
        }

        return $type;
    }
}
