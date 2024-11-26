<?php

namespace App\Relations\Belongs;

use App\Models\Deal;

trait BelongsToDeal
{
    /**
     * Belongs to deal.
     */
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }
}
