<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ContactsModel extends Model
{
    /**
     * table name
     */
    protected $table = 'contacts';

    /**
     * @param $allInputs
     * @return mixed
     */
    public function insertRow($allInputs)
    {
        return ContactsModel::insertGetId(
            [
                'client_id' => $allInputs['client_id'],
                'employee_id' => $allInputs['employee_id'],
                'created_at' => Carbon::now(),
                'date' => $allInputs['date']
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
        return ContactsModel::where('id', '=', $id)->update(
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
    public function getRules($rulesType)
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
    public function trySearchContactsByValue($type, $value, $paginationLimit = 10)
    {
        return ClientsModel::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    /**
     * @return int
     */
    public static function countContacts()
    {
        return ContactsModel::all()->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(ClientsModel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employees()
    {
        return $this->belongsTo(EmployeesModel::class, 'employee_id', 'id');
    }

    public function getAllContacts()
    {
        return $this::all()->sortByDesc('created_at');
    }
}