<?php

namespace App\Relations\Has;

use App\Models\SalesModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManySales
{

    public function sales(): HasMany
    {
        return $this->hasMany(SalesModel::class);
    }
}
