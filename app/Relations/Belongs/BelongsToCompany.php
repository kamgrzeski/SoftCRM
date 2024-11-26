<?php

namespace App\Relations\Belongs;


use App\Models\Company;

trait BelongsToCompany
{
    /**
     * Belongs to company.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
