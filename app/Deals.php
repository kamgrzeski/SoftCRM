<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deals extends Model
{
    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return Deals::insert(
            [
                'name' => $allInputs['name'],
                'start_time' => $allInputs['start_time'],
                'end_time' => $allInputs['end_time'],
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
        return Deals::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'start_time' => $allInputs['start_time'],
                'end_time' => $allInputs['end_time'],
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
                    'start_time' => 'required',
                    'end_time' => 'required',
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
        $findDealsById = Deals::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findDealsById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companies()
    {
        return $this->belongsTo(Companies::class);
    }

    public static function trySearchDealsByValue($type, $value, $paginationLimit = 10)
    {
        return Deals::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }
}
