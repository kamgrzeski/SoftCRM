<?php

namespace App\Relations\Has;


use App\Models\EmployeesModel;
use App\Models\FinancesModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyFinances
{
    /**
     * Get the finances for the company.
     */
    public function finances(): HasMany
    {
        return $this->hasMany(FinancesModel::class);
    }
}
