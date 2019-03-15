<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ReportsModel extends Model
{
    protected $table = 'reports';

    public static function insertRow($allInputs)
    {
        return self::insertGetId(
            [
                'name' => $allInputs['name'],
                'companies_id' => $allInputs['companies_id'],
                'clients_id' => $allInputs['clients_id'],
                'created_at' => Carbon::now(),
                'is_active' => 1
            ]
        );
    }

    public static function updateRow($id, $allInputs)
    {
        return self::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'companies_id' => $allInputs['companies_id'],
                'clients_id' => $allInputs['clients_id'],
                'updated_at' => Carbon::now(),
                'is_active' => 1
            ]);
    }

    public static function setActive($id, $activeType)
    {
        $findReportsById = self::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findReportsById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function countReports()
    {
        return self::all()->count();
    }

    public static function trySearchReportsByValue($type, $value, $paginationLimit = 10)
    {
        return self::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }
}
