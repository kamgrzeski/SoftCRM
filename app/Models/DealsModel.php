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

    public function countDeals(): int
    {
        return $this->get()->count();
    }

    public static function getDealsInLatestMonth() {
        $dealsCount = self::where('created_at', '>=', now()->subMonth())->count();
        $allDeals = self::all()->count();

        return ($allDeals / 100) * $dealsCount;
    }

    public function getDeactivated(): int
    {
        return $this->where('is_active', '=', 0)->count();
    }

    public function getPaginate()
    {
        return $this->orderByDesc('id')->paginate(SettingsModel::where('key', 'pagination_size')->get()->last()->value);
    }
}
