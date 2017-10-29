<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait OwnedByAgency
{
    public static function bootOwnedByAgency()
    {
        static::addGlobalScope('by_owner', function (Builder $builder) {
            if (auth()->user() && auth()->user()->agency) {
                $builder->where('owner_id', auth()->user()->agency->id);
            }
        });
    }
}
