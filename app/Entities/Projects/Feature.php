<?php

namespace App\Entities\Projects;

use App\Entities\Projects\FeaturePresenter;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Feature extends Model {

    use PresentableTrait;

    protected $presenter = FeaturePresenter::class;
	protected $guarded = ['id','created_at','updated_at'];

}
