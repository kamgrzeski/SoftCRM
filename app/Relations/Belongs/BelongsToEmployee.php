<?php

namespace App\Relations\Belongs;

use App\Models\Employee;

trait BelongsToEmployee
{
    /**
     * Belongs to employee.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
