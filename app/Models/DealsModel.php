<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DealsModel extends Model
{
    protected $table = 'deals';

    public function insertGetId($allInputs)
    {
        return self::insert(
            [
                'name' => $allInputs['name'],
                'start_time' => $allInputs['start_time'],
                'end_time' => $allInputs['end_time'],
                'companies_id' => $allInputs['companies_id'],
                'created_at' => Carbon::now(),
                'is_active' => 1
            ]
        );
    }

    public function updateRow($id, $allInputs)
    {
        return self::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'start_time' => $allInputs['start_time'],
                'end_time' => $allInputs['end_time'],
                'companies_id' => $allInputs['companies_id'],
                'is_active' => 1
            ]);
    }

    public function setActive($id, $activeType)
    {
        $findDealsById = self::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findDealsById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function countDeals()
    {
        return count(self::get());
    }

    public function companies()
    {
        return $this->belongsTo(CompaniesModel::class);
    }

    public static function getDealsInLatestMonth() {
        $dealsCount = self::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $allDeals = self::all()->count();

        $percentage = ($allDeals / 100) * $dealsCount;

        return $percentage;
    }

    public static function getDeactivated()
    {
        return self::where('is_active', '=', 0)->count();
    }

    public function getPluckCompanies()
    {
        return self::pluck('name', 'id');
    }
}
