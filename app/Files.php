<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return Files::insert(
            [
                'name' => $allInputs['name'],
                'companies_id' => $allInputs['companies_id'],
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
        return Files::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'companies_id' => $allInputs['companies_id'],
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
        $findFilesById = Files::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findFilesById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return int
     */
    public static function countFiles()
    {
        return count(Files::get());
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function trySearchFilesByValue($type, $value, $paginationLimit = 10)
    {
        return Files::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }
}
