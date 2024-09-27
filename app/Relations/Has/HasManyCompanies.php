<?php

namespace App\Relations\Has;

use App\Models\CompaniesModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyCompanies
{
    public function companies(): HasMany
    {
        return $this->hasMany(CompaniesModel::class, 'client_id');
    }
}
