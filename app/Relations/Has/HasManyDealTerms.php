<?php

namespace App\Relations\Has;

use App\Models\DealsTermsModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyDealTerms
{
    /**
     * Has many deals.
     */
    public function dealTerms(): HasMany
    {
        return $this->hasMany(DealsTermsModel::class, 'deal_id');
    }
}
