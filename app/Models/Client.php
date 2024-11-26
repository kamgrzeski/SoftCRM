<?php

namespace App\Models;

use App\Relations\Has\HasManyCompanies;
use App\Relations\Has\HasManyEmployees;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes, HasManyEmployees, HasManyCompanies;

    protected $fillable = [
        'full_name', 'phone', 'email', 'section', 'budget', 'location', 'zip', 'city', 'country', 'is_active', 'admin_id'
    ];
}
