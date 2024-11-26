<?php

namespace App\Relations\Has;

use App\Models\DealTerm;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyDealTerms
{
    /**
     * Has many deals.
     */
    public function dealTerms(): HasMany
    {
        return $this->hasMany(DealTerm::class, 'deal_id');
    }
}
