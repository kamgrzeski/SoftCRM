<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return Contacts::insert(
            [
                'client_id' => $allInputs['client_id'],
                'employee_id' => $allInputs['employee_id'],
                'date' => $allInputs['date']
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
        return Contacts::where('id', '=', $id)->update(
            [
                'client_id' => $allInputs['client_id'],
                'employee_id' => $allInputs['employee_id'],
                'date' => $allInputs['date']
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
                    'client_id' => 'required|string',
                    'employee_id' => 'required|integer',
                    'date' => 'required',
                ];
        }
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function trySearchContactsByValue($type, $value, $paginationLimit = 10)
    {
        return Client::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    /**
     * @return int
     */
    public static function countContacts()
    {
        return count(Contacts::get());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function employees()
    {
        return $this->belongsTo(Employees::class, 'employee_id', 'id');
    }
}