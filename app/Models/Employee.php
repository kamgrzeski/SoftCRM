<?php

namespace App\Models;

use App\Relations\Belongs\BelongsToClient;
use App\Relations\Belongs\BelongsToDeal;
use App\Relations\Has\HasManyCompanies;
use App\Relations\Has\HasManyTasks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes, HasManyCompanies, BelongsToDeal, BelongsToClient, HasManyTasks;

    protected $fillable = ['full_name', 'email', 'phone', 'client_id', 'is_active', 'job', 'note', 'admin_id', 'created_at',
        'updated_at', 'deleted_at'
    ];
}

