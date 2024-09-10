<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealsModel extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'companies_id', 'is_active'];

    protected $table = 'deals';
    protected $dates = ['deleted_at'];

    public function companies()
    {
        return $this->belongsTo(CompaniesModel::class);
    }

    public function dealTerms()
    {
        return $this->hasMany(DealsTermsModel::class, 'deal_id');
    }
}
