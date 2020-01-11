<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Config;

class DealsModel extends Model
{
    protected $table = 'deals';

    public function companies()
    {
        return $this->belongsTo(CompaniesModel::class);
    }

    public function storeDeal(array $requestedData, int $adminId) : bool
    {
        return $this->insert(
            [
                'name' => $requestedData['name'],
                'start_time' => $requestedData['start_time'],
                'end_time' => $requestedData['end_time'],
                'companies_id' => $requestedData['companies_id'],
                'created_at' => Carbon::now(),
                'is_active' => 1,
                'admin_id' => $adminId
            ]
        );
    }

    public function updateDeal(int $dealId, array $requestedData) : bool
    {
        return $this->where('id', '=', $dealId)->update(
            [
                'name' => $requestedData['name'],
                'start_time' => $requestedData['start_time'],
                'end_time' => $requestedData['end_time'],
                'companies_id' => $requestedData['companies_id']
            ]);
    }

    public function setActive(int $dealId, bool $activeType) : bool
    {
        return $this->where('id', '=', $dealId)->update(['is_active' => $activeType]);
    }

    public function countDeals() : int
    {
        return $this->get()->count();
    }

    public static function getDealsInLatestMonth() {
        $dealsCount = self::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $allDeals = self::all()->count();

        $percentage = ($allDeals / 100) * $dealsCount;

        return $percentage;
    }

    public function getDeactivated() : int
    {
        return $this->where('is_active', '=', 0)->count();
    }

    public function getPluckCompanies()
    {
        return $this->pluck('name', 'id');
    }

    public function getPaginate()
    {
        return $this->paginate(Config::get('crm_settings.pagination_size'));
    }

    public function getDeal(int $dealId) : self
    {
        return $this->find($dealId);
    }
}
