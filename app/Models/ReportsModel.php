<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ReportsModel extends Model
{

    /**
     * table name
     */
    protected $table = 'reports';

    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return ReportsModel::insertGetId(
            [
                'name' => $allInputs['name'],
                'companies_id' => $allInputs['companies_id'],
                'clients_id' => $allInputs['clients_id'],
                'created_at' => Carbon::now(),
                'is_active' => 1
            ]
        );
    }

    /**
     * @param $id
     * @param $allInputs
     * @return mixed
     */
    public static function updateRow($id, $allInputs)
    {
        return ReportsModel::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'companies_id' => $allInputs['companies_id'],
                'clients_id' => $allInputs['clients_id'],
                'updated_at' => Carbon::now(),
                'is_active' => 1
            ]);
    }

    /**
     * @param $rulesType
     * @return array
     */
    public static function getRules($rulesType)
    {
        switch ($rulesType) {
            case 'STORE':
                return [
                    'name' => 'required',
                    'companies_id' => 'required',
                ];
        }
    }

    /**
     * @param $id
     * @param $activeType
     * @return bool
     */
    public static function setActive($id, $activeType)
    {
        $findReportsById = ReportsModel::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findReportsById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return int
     */
    public static function countReports()
    {
        return ReportsModel::all()->count();
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function trySearchReportsByValue($type, $value, $paginationLimit = 10)
    {
        return ReportsModel::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }
}
