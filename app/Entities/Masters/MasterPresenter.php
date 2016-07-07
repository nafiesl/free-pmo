<?php

namespace App\Entities\Masters;

use Laracasts\Presenter\Presenter;

class MasterPresenter extends Presenter
{
    public function fullName()
    {
        return $this->name;
    }

}