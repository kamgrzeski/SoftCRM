<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ReportsModel extends Model
{
    protected $table = 'reports';

    public static function storeReport(array $requestedData) : int
    {
        return self::insertGetId(
            [
                'name' => $requestedData['name'],
                'companies_id' => $requestedData['companies_id'],
                'clients_id' => $requestedData['clients_id'],
                'created_at' => Carbon::now(),
                'is_active' => 1
            ]
        );
    }

    public static function updateReport(int $reportId, array $requestedData) : bool
    {
        return self::where('id', '=', $reportId)->update(
            [
                'name' => $requestedData['name'],
                'companies_id' => $requestedData['companies_id'],
                'clients_id' => $requestedData['clients_id'],
                'updated_at' => Carbon::now(),
                'is_active' => 1
            ]);
    }

    public static function setActive(int $reportId, int $activeType) : bool
    {
        $findReportsById = self::where('id', '=', $reportId)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findReportsById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function countReports() : int
    {
        return self::all()->count();
    }
}
