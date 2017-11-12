<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
    protected $table = 'mailing';

    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return Mailing::insert(
            [
                'name' => $allInputs['name'],
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
        return Mailing::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
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
                    'name' => 'required'
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
        $findMailingById = Mailing::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findMailingById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return int
     */
    public static function countMailing()
    {
        return count(Mailing::get());
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function trySearchMailingByValue($type, $value, $paginationLimit = 10)
    {
        return Mailing::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    public static function addEmailToMailManager($allInputs)
    {
        die('coming soon');
    }
}
