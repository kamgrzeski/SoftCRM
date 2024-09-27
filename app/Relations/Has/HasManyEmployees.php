<?php

namespace App\Relations\Has;


use App\Models\EmployeesModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyEmployees
{
    /**
     * Get the employees for the company.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(EmployeesModel::class, 'client_id');
    }
}
