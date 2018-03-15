<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EmployeesModel extends Model
{
    /**
     * table name
     */
    protected $table = 'employees';
    /**
     *
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return EmployeesModel::insertGetId(
            [
                'full_name' => $allInputs['full_name'],
                'phone' => $allInputs['phone'],
                'email' => $allInputs['email'],
                'job' => $allInputs['job'],
                'note' => $allInputs['note'],
                'client_id' => $allInputs['client_id'],
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
        return EmployeesModel::where('id', '=', $id)->update(
            [
                'full_name' => $allInputs['full_name'],
                'phone' => $allInputs['phone'],
                'email' => $allInputs['email'],
                'job' => $allInputs['job'],
                'note' => $allInputs['note'],
                'client_id' => $allInputs['client_id'],
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
                    'full_name' => 'required',
                    'phone' => 'required',
                    'email' => 'required',
                    'job' => 'required',
                    'note' => 'required',
                    'client_id' => 'required'
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
        $findEmployeesById = EmployeesModel::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findEmployeesById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function trySearchEmployeesByValue($type, $value, $paginationLimit = 10)
    {
        return EmployeesModel::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    /**
     * @return int
     */
    public static function countEmployees()
    {
        return count(EmployeesModel::get());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany(CompaniesModel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deals()
    {
        return $this->belongsTo(DealsModel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(ClientsModel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(ContactsModel::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(TasksModel::class, 'employee_id');
    }

    /**
     * @return float|int
     */
    public static function getEmployeesInLatestMonth() {
        $employeesCount = EmployeesModel::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $allEmployees = EmployeesModel::all()->count();

        $percentage = ($allEmployees / 100) * $employeesCount;

        return $percentage;
    }
}

