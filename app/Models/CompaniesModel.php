<?php

namespace App\Models;

use App\Relations\Belongs\BelongsToClient;
use App\Relations\Belongs\BelongsToEmployee;
use App\Relations\Has\HasManyDeals;
use App\Relations\Has\HasManyFinances;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompaniesModel extends Model
{
    use SoftDeletes, BelongsToClient, HasManyDeals, HasManyFinances, BelongsToEmployee;

    protected $fillable = [
        'name',
        'tax_number',
        'phone',
        'city',
        'billing_address',
        'country',
        'postal_code',
        'employees_size',
        'fax',
        'description',
        'client_id',
        'created_at',
        'is_active',
        'admin_id'
    ];

    protected $table = 'companies';
    protected $dates = ['deleted_at'];
}
