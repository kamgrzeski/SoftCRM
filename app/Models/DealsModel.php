<?php

namespace App\Models;

use App\Relations\Belongs\BelongsToCompany;
use App\Relations\Has\HasManyDealTerms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealsModel extends Model
{
    use SoftDeletes, BelongsToCompany, HasManyDealTerms;

    protected $fillable = ['name', 'companies_id', 'is_active'];

    protected $table = 'deals';
    protected $dates = ['deleted_at'];
}
