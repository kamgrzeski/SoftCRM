<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MailingModel extends Model
{
    protected $table = 'mailing';

    /**
     * @param $allInputs
     * @return mixed
     */
    public function insertRow($allInputs)
    {
        return MailingModel::insertGetId(
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
    public function updateRow($id, $allInputs)
    {
        return MailingModel::where('id', '=', $id)->update(
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
    public function getRules($rulesType)
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
    public function setActive($id, $activeType)
    {
        $findMailingById = MailingModel::where('id', '=', $id)->update(
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
        return MailingModel::all()->count();
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function trySearchMailingByValue($type, $value, $paginationLimit = 10)
    {
        return MailingModel::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    public static function addEmailToMailManager($allInputs)
    {
        die('coming soon');
    }
}
