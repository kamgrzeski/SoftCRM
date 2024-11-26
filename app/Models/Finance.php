<?php

namespace App\Models;

use App\Relations\Belongs\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Finance extends Model
{
    use HasFactory, SoftDeletes, BelongsToCompany;

    protected $fillable = ['name', 'company_id', 'gross', 'net', 'vat', 'description', 'category', 'type', 'date',
        'is_active', 'created_at', 'updated_at' ];

    protected $casts = [
        'date' => 'datetime',
    ];
}
