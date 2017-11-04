<?php

namespace App\Entities\Payments;

use App\Entities\Payments\PaymentPresenter;
use App\Entities\Projects\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Payment extends Model
{
    use PresentableTrait;

    protected $presenter = PaymentPresenter::class;
    protected $guarded   = ['id', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('by_owner_project', function (Builder $builder) {
        //     if (auth()->user() && auth()->user()->agency) {
        //         $projectIds = auth()->user()->agency->projects->pluck('id')->all();
        //         $builder->whereIn('project_id', $projectIds);
        //     }
        // });
    }

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
        return paymentTypes($this->type_id);
    }
}
