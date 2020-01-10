<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Config;

class TasksModel extends Model
{
    protected $table = 'tasks';

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
                'created_at' => Carbon::now(),
                'admin_id' => $adminId
            ]
        );
    }

    public function updateTask(int $taskId, array $requestedData)
    {
        return $this->where('id', '=', $taskId)->update(
            [
                'name' => $requestedData['name'],
                'employee_id' => $requestedData['employee_id'],
                'duration' => $requestedData['duration'],
                'is_active' => 1,
                'updated_at' => Carbon::now()
            ]);
    }

    public function setActive(int $taskId, int $activeType)
    {
        return $this->where('id', '=', $taskId)->update(['is_active' => $activeType]);
    }

    public function setCompleted(int $taskId, int $completeType)
    {
        return $this->where('id', '=', $taskId)->update(['completed' => $completeType]);
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
        return $this->all()->sortByDesc('created_at');
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
