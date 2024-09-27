<?php

namespace App\Relations\Has;


use App\Models\DealsModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyDeals
{
    /**
     * Has many deals.
     */
    public function deals(): HasMany
    {
        return $this->hasMany(DealsModel::class, 'id');
    }
}
