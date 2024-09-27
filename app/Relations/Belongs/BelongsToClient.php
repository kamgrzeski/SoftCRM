<?php

namespace App\Relations\Belongs;

use App\Models\ClientsModel;

trait BelongsToClient
{
    /**
     * Belongs to client.
     */
    public function client()
    {
        return $this->belongsTo(ClientsModel::class);
    }
}
