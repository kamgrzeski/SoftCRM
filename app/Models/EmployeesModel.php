<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class EmployeesModel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'company_id',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $table = 'employees';
    protected $dates = ['deleted_at'];

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

    public function countEmployees(): int
    {
        return $this->all()->count();
    }

    public function getEmployeesInLatestMonth() : float
    {
        $employeesCount = $this->where('created_at', '>=', now()->subMonth())->count();
        $allEmployees = $this->all()->count();

        return ($allEmployees / 100) * $employeesCount;
    }

    public function getDeactivated(): int
    {
        return $this->where('is_active', '=', 0)->count();
    }

    public function getEmployees($createForm = false)
    {
        if($createForm) {
            return $this->pluck('full_name', 'id');
        }

        $query = $this->all()->sortBy('created_at');

        foreach($query as $key => $value) {
            Arr::add($query[$key], 'taskCount', $this->getEmployeesTaskCount($value->id));
        }

        return $query;
    }

    private function getEmployeesTaskCount(int $id) : int
    {
        return TasksModel::where('employee_id', $id)->get()->count();
    }

    public function getPaginate()
    {
        return $this->orderByDesc('id')->paginate(SettingsModel::where('key', 'pagination_size')->get()->last()->value);
    }
}

