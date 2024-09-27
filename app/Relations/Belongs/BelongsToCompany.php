<?php

namespace App\Relations\Belongs;


use App\Models\CompaniesModel;

trait BelongsToCompany
{
    /**
     * Belongs to company.
     */
    public function company()
    {
        return $this->belongsTo(CompaniesModel::class);
    }
}
