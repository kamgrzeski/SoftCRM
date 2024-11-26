<?php

namespace App\Relations\Has;


use App\Models\Employee;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyEmployees
{
    /**
     * Get the employees for the company.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'client_id');
    }
}
