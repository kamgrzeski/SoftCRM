<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return Reports::insert(
            [
                'name' => $allInputs['name'],
                'companies_id' => $allInputs['companies_id'],
                'clients_id' => $allInputs['clients_id'],
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
        return Reports::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'companies_id' => $allInputs['companies_id'],
                'clients_id' => $allInputs['clients_id'],
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
        $findReportsById = Reports::where('id', '=', $id)->update(
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
        return count(Reports::get());
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function trySearchReportsByValue($type, $value, $paginationLimit = 10)
    {
        return Reports::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }
}
