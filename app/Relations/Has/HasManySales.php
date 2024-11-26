<?php

namespace App\Relations\Has;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManySales
{

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'product_id');
    }
}
