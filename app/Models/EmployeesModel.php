<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeesModel extends Model
{
    use SoftDeletes;

    protected $table = 'employees';

    public function getCountEmployees()
    {
        return $this->all()->count();
    }

    public function getCountOfDeactivatedEmployees()
    {
        return $this->where('is_active', 0)->get()->count();
    }

    public function getCountOfEmployeesInLatestMonth()
    {

    }

    public function getEmployeesAssignedToClient($employeeId)
    {
        return $this->where('client_id', $employeeId)->get()->count();
    }

    public function getEmployeesDetailsAssignedToClient($employeeId)
    {
        return $this->where('client_id', $employeeId)->get();
    }

    public function getEmployees()
    {
        return $this->all();
    }

    public function getEmployeesDetails($employeeId)
    {
        return $this->where('id', $employeeId)->get()->last();
    }

    public function deleteEmployee($employeeId)
    {
        $employeeModel = self::find($employeeId);

        if (is_null($employeeModel)) {
            return false;
        }

        $employeeModel->delete();

        return true;
    }
}