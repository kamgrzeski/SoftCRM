<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ContactsModel extends Model
{
    protected $table = 'contacts';

    public function insertRow($allInputs)
    {
        return self::insertGetId(
            [
                'client_id' => $allInputs['client_id'],
                'employee_id' => $allInputs['employee_id'],
                'created_at' => Carbon::now(),
                'date' => $allInputs['date']
            ]
        );
    }

    public function updateRow($id, $allInputs)
    {
        return self::where('id', '=', $id)->update(
            [
                'client_id' => $allInputs['client_id'],
                'employee_id' => $allInputs['employee_id'],
                'date' => $allInputs['date']
            ]);
    }

    public static function countContacts()
    {
        return self::all()->count();
    }

    public function client()
    {
        return $this->belongsTo(ClientsModel::class);
    }

    public function employees()
    {
        return $this->belongsTo(EmployeesModel::class, 'employee_id', 'id');
    }

    public function getAllContacts()
    {
        return $this::all()->sortByDesc('created_at');
    }
}