<?php

namespace App\Entities\Masters;

use App\Entities\Masters\MasterPresenter;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Master extends Model {

    use PresentableTrait;

    protected $presenter = MasterPresenter::class;
	protected $guarded = ['id','created_at','updated_at'];

}
