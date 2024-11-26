<?php

namespace App\Relations\Belongs;

use App\Models\Client;

trait BelongsToClient
{
    /**
     * Belongs to client.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
