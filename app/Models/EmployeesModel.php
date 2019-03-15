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

    public function contacts()
    {
        return $this->hasMany(ContactsModel::class, 'employee_id');
    }

    public function tasks()
    {
        return $this->hasMany(TasksModel::class, 'employee_id');
    }

    public function insertRow($allInputs)
    {
        return self::insertGetId(
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

    public function updateRow($id, $allInputs)
    {
        return self::where('id', '=', $id)->update(
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

    public function setActive($id, $activeType)
    {
        $findEmployeesById = self::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findEmployeesById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function countEmployees()
    {
        return self::all()->count();
    }

    public static function getEmployeesInLatestMonth() {
        $employeesCount = self::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $allEmployees = self::all()->count();

        $percentage = ($allEmployees / 100) * $employeesCount;

        return $percentage;
    }

    public static function getDeactivated()
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

    public function getEmployeeDetails(int $id)
    {
        $query = self::find($id);

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

