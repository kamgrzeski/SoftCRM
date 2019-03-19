<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EmployeesModel extends Model
{
    protected $table = 'employees';

    public function companies()
    {
        return $this->hasMany(CompaniesModel::class);
    }

    public function deals()
    {
        return $this->belongsTo(DealsModel::class);
    }

    public function client()
    {
        return $this->belongsTo(ClientsModel::class);
    }

    public function tasks()
    {
        return $this->hasMany(TasksModel::class, 'employee_id');
    }

    public function insertEmployee($requestedData)
    {
        return self::insertGetId(
            [
                'full_name' => $requestedData['full_name'],
                'phone' => $requestedData['phone'],
                'email' => $requestedData['email'],
                'job' => $requestedData['job'],
                'note' => $requestedData['note'],
                'client_id' => $requestedData['client_id'],
                'created_at' => Carbon::now(),
                'is_active' => 1
            ]
        );
    }

    public function updateEmployee($employeeId, $requestedData)
    {
        return self::where('id', '=', $employeeId)->update(
            [
                'full_name' => $requestedData['full_name'],
                'phone' => $requestedData['phone'],
                'email' => $requestedData['email'],
                'job' => $requestedData['job'],
                'note' => $requestedData['note'],
                'client_id' => $requestedData['client_id'],
                'updated_at' => Carbon::now(),
                'is_active' => 1
            ]);
    }

    public function setActive($employeeId, $activeType)
    {
        $findEmployeesById = self::where('id', '=', $employeeId)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findEmployeesById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function countEmployees()
    {
        return self::all()->count();
    }

    public function getEmployeesInLatestMonth() {
        $employeesCount = self::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $allEmployees = self::all()->count();

        $percentage = ($allEmployees / 100) * $employeesCount;

        return $percentage;
    }

    public function getDeactivated()
    {
        return self::where('is_active', '=', 0)->count();
    }

    public function getEmployees()
    {
        $query = self::all()->sortByDesc('created_at');

        foreach($query as $key => $value) {
            $query[$key]->is_active = $query[$key]->is_active  ? 'Active' : 'Deactive';
            Arr::add($query[$key], 'taskCount', count($value->task));
        }

        return $query;
    }

    public function getEmployeeDetails(int $employeeId)
    {
        $query = self::find($employeeId);

        Arr::add($query, 'taskCount', count($query->tasks));

        return $query;
    }

    public function getEmployee()
    {
        return self::pluck('full_name', 'id');
    }

    public function getClients()
    {
        return self::pluck('full_name', 'id');
    }
}

