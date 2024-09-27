<?php

namespace App\Relations\Belongs;

use App\Models\DealsModel;

trait BelongsToDeal
{
    /**
     * Belongs to deal.
     */
    public function deal()
    {
        return $this->belongsTo(DealsModel::class);
    }
}
