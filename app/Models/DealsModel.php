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

    public function insertDeal($requestedData)
    {
        return self::insert(
            [
                'name' => $requestedData['name'],
                'start_time' => $requestedData['start_time'],
                'end_time' => $requestedData['end_time'],
                'companies_id' => $requestedData['companies_id'],
                'created_at' => Carbon::now(),
                'is_active' => 1
            ]
        );
    }

    public function updateDeal($dealId, $requestedData)
    {
        return self::where('id', '=', $dealId)->update(
            [
                'name' => $requestedData['name'],
                'start_time' => $requestedData['start_time'],
                'end_time' => $requestedData['end_time'],
                'companies_id' => $requestedData['companies_id'],
                'is_active' => 1
            ]);
    }

    public function setActive($dealId, $activeType)
    {
        $findDealsById = self::where('id', '=', $dealId)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findDealsById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function countDeals()
    {
        return self::get()->count();
    }

    public static function getDealsInLatestMonth() {
        $dealsCount = self::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $allDeals = self::all()->count();

        $percentage = ($allDeals / 100) * $dealsCount;

        return $percentage;
    }

    public function getDeactivated()
    {
        return self::where('is_active', '=', 0)->count();
    }

    public function getPluckCompanies()
    {
        return self::pluck('name', 'id');
    }

    public function getPaginate()
    {
        return self::paginate(Config::get('crm_settings.pagination_size'));
    }

    public function getDeal(int $dealId)
    {
        return self::find($dealId);
    }
}
