<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;
use Illuminate\Database\Eloquent\SoftDeletes;

class TasksModel extends Model
{
    use SoftDeletes;

    protected $table = 'tasks';
    protected $dates = ['deleted_at'];

    public function employees()
    {
        return $this->belongsTo(EmployeesModel::class, 'employee_id');
    }

    public function storeTask(array $requestedData, int $adminId)
    {
        return $this->insertGetId(
            [
                'name' => $requestedData['name'],
                'employee_id' => $requestedData['employee_id'],
                'duration' => $requestedData['duration'],
                'is_active' => 1,
                'created_at' => now(),
                'admin_id' => $adminId
            ]
        );
    }

    public function updateTask(int $taskId, array $requestedData) : int
    {
        return $this->where('id', '=', $taskId)->update(
            [
                'name' => $requestedData['name'],
                'employee_id' => $requestedData['employee_id'],
                'duration' => $requestedData['duration'],
                'updated_at' => now()
            ]
        );
    }

    public function setActive(int $taskId, int $activeType) : int
    {
        return $this->where('id', '=', $taskId)->update(
            [
                'is_active' => $activeType,
                'updated_at' => now()
            ]
        );
    }

    public function setCompleted(int $taskId, int $completeType) : int
    {
        return $this->where('id', '=', $taskId)->update(
            [
                'completed' => $completeType,
                'updated_at' => now()
            ]
        );
    }

    public function countTasks()
    {
        return $this->all()->count();
    }

    public static function trySearchTasksByValue($type, $value, $paginationLimit = 10)
    {
        return self::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    public function getAllCompletedTasks()
    {
        $tasks = $this->where('completed', '=', 1)->count();

        $taskAll = $this->all()->count();

        $percentage = round(($tasks / $taskAll) * 100);

        return $tasks . ' (' . $percentage .  '%)';
    }

    public function getTask(int $taskId)
    {
        return $this->find($taskId);
    }

    public function getTasks()
    {
        return $this->all()->sortBy('created_at');
    }

    public function getPaginate()
    {
        return $this->paginate(Config::get('crm_settings.pagination_size'));
    }

    public function getAllUncompletedTasks()
    {
        $tasks = $this->where('completed', '=', 0)->count();

        $taskAll = $this->all()->count();

        $percentage = round(($tasks / $taskAll) * 100);

        return $tasks . ' (' . $percentage .  '%)';
    }
}
