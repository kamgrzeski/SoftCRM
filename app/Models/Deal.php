<?php

namespace App\Models;

use App\Relations\Belongs\BelongsToCompany;
use App\Relations\Has\HasManyDealTerms;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    use HasFactory, SoftDeletes, BelongsToCompany, HasManyDealTerms;

    protected $fillable = ['name', 'start_time', 'end_time', 'company_id', 'is_active', 'admin_id'];
}
