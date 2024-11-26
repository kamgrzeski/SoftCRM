<?php

namespace App\Relations\Has;


use App\Models\Employee;
use App\Models\Finance;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyFinances
{
    /**
     * Get the finances for the company.
     */
    public function finances(): HasMany
    {
        return $this->hasMany(Finance::class);
    }
}
