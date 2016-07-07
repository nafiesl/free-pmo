<?php

namespace App\Entities\Projects;

use App\Entities\Payments\Payment;
use App\Entities\Projects\ProjectPresenter;
use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Project extends Model {

    use PresentableTrait;

    protected $presenter = ProjectPresenter::class;
    protected $guarded = ['id','created_at','updated_at'];
	// protected $dates = ['start_date','end_date'];

    public function features()
    {
        return $this->hasMany(Feature::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class)->orderBy('date','desc');
    }

    public function customer()
    {
        return $this->belongsTo(User::class,'customer_id');
    }

}
