<?php

namespace App\Models;

use App\Relations\Belongs\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancesModel extends Model
{
    use SoftDeletes, BelongsToCompany;

    protected $fillable = [
        'companies_id',
        'gross',
        'net',
        'vat',
        'description',
        'is_active',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    protected $table = 'finances';
}
