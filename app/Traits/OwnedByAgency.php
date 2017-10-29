<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait OwnedByAgency
{
    public static function bootOwnedByAgency()
    {
        static::addGlobalScope('by_owner', function (Builder $builder) {
            if ( ! is_null(auth()->user()->agency)) {
                $builder->where('owner_id', auth()->user()->agency->id);
            } else {
                $builder->where('owner_id', 0);
            }
        });
    }
}
