<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TasksModel extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'employee_id', 'duration', 'is_active', 'completed', 'admin_id'];

    protected $table = 'tasks';
    protected $dates = ['deleted_at'];

    public function employees()
    {
        return $this->belongsTo(EmployeesModel::class, 'employee_id');
    }

    public function countTasks(): int
    {
        return $this->all()->count();
    }

    public function getAllCompletedTasks(): string
    {
        $tasks = $this->where('completed', '=', 1)->count();

        $taskAll = $this->all()->count();

        $percentage = round(($tasks / $taskAll) * 100);

        return $tasks . ' (' . $percentage .  '%)';
    }

    public function getPaginate()
    {
        return $this->orderByDesc('id')->paginate(SettingsModel::where('key', 'pagination_size')->get()->last()->value);
    }

    public function getAllUncompletedTasks()
    {
        return [
            'tasks' => $this->where('completed', '=', 0)->count(),
            'all' => $this->all()->count()
        ];
    }
}
