<?php

namespace App\Relations\Has;

use App\Models\Company;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyCompanies
{
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class, 'client_id');
    }
}
