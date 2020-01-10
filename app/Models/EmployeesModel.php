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

    public function insertEmployee(array $requestedData, int $adminId) : int
    {
        return $this->insertGetId(
            [
                'full_name' => $requestedData['full_name'],
                'phone' => $requestedData['phone'],
                'email' => $requestedData['email'],
                'job' => $requestedData['job'],
                'note' => $requestedData['note'],
                'client_id' => $requestedData['client_id'],
                'created_at' => Carbon::now(),
                'is_active' => 1,
                'admin_id' => $adminId
            ]
        );
    }

    public function updateEmployee(int $employeeId, array $requestedData) : bool
    {
        return $this->where('id', '=', $employeeId)->update(
            [
                'full_name' => $requestedData['full_name'],
                'phone' => $requestedData['phone'],
                'email' => $requestedData['email'],
                'job' => $requestedData['job'],
                'note' => $requestedData['note'],
                'client_id' => $requestedData['client_id'],
                'updated_at' => Carbon::now(),
            ]);
    }

    public function setActive(int $employeeId, int $activeType) : bool
    {
        return $this->where('id', '=', $employeeId)->update(['is_active' => $activeType]);
    }

    public function countEmployees() : int
    {
        return $this->all()->count();
    }

    public function getEmployeesInLatestMonth() : float
    {
        $employeesCount = $this->where('created_at', '>=', Carbon::now()->subMonth())->count();
        $allEmployees = $this->all()->count();

        $percentage = ($allEmployees / 100) * $employeesCount;

        return $percentage;
    }

    public function getDeactivated() : int
    {
        return $this->where('is_active', '=', 0)->count();
    }

    public function getEmployees()
    {
        $query = $this->all()->sortByDesc('created_at');

        foreach($query as $key => $value) {
            $query[$key]->is_active = $query[$key]->is_active  ? 'Active' : 'Deactive';
            Arr::add($query[$key], 'taskCount', $this->getEmployeesTaskCount($value->id));
        }

        return $query;
    }

    public function getEmployeeDetails(int $employeeId) : self
    {
        $query = $this->find($employeeId);

        Arr::add($query, 'taskCount', count($query->tasks));

        return $query;
    }

    public function getEmployee()
    {
        return $this->pluck('full_name', 'id');
    }

    public function getClients()
    {
        return $this->pluck('full_name', 'id');
    }

    private function getEmployeesTaskCount(int $id) : int
    {
        return TasksModel::where('employee_id', $id)->get()->count();
    }
}

