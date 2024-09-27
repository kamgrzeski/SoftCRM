<?php

namespace App\Relations\Belongs;

use App\Models\EmployeesModel;

trait BelongsToEmployee
{
    /**
     * Belongs to employee.
     */
    public function employee()
    {
        return $this->belongsTo(EmployeesModel::class);
    }
}
