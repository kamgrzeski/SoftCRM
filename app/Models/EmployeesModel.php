<?php

namespace App\Models;

use App\Relations\Belongs\BelongsToClient;
use App\Relations\Belongs\BelongsToDeal;
use App\Relations\Has\HasManyCompanies;
use App\Relations\Has\HasManyTasks;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeesModel extends Model
{
    use SoftDeletes, HasManyCompanies, BelongsToDeal, BelongsToClient, HasManyTasks;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'company_id',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $table = 'employees';
    protected $dates = ['deleted_at'];
}

