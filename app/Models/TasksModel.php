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

    public function storeTask(array $requestedData)
    {
        return self::insertGetId(
            [
                'name' => $requestedData['name'],
                'employee_id' => $requestedData['employee_id'],
                'duration' => $requestedData['duration'],
                'is_active' => 1,
                'created_at' => Carbon::now()
            ]
        );
    }

    public function updateTask(int $taskId, array $requestedData)
    {
        return self::where('id', '=', $taskId)->update(
            [
                'name' => $requestedData['name'],
                'employee_id' => $requestedData['employee_id'],
                'duration' => $requestedData['duration'],
                'is_active' => 1,
                'updated_at' => Carbon::now()
            ]);
    }

    public function setActive(int $taskId, $activeType)
    {
        $findTasksById = self::where('id', '=', $taskId)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findTasksById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function setCompleted(int $taskId, $completeType)
    {
        $findTasksById = self::where('id', '=', $taskId)->update(
            [
                'completed' => $completeType
            ]);

        if ($findTasksById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function countTasks()
    {
        return self::all()->count();
    }

    public static function trySearchTasksByValue($type, $value, $paginationLimit = 10)
    {
        return self::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    public function getAllCompletedTasks()
    {
        $tasks = self::where('completed', '=', 1)->count();

        $taskAll = self::all()->count();

        $percentage = round(($tasks / $taskAll) * 100);

        return $tasks . ' (' . $percentage .  '%)';
    }

    public function getTask(int $taskId)
    {
        return self::find($taskId);
    }

    public function getTasks()
    {
        return self::all()->sortByDesc('created_at');
    }

    public function getPaginate()
    {
        return self::paginate(Config::get('crm_settings.pagination_size'));
    }

    public function getAllUncompletedTasks()
    {
        $tasks = self::where('completed', '=', 0)->count();

        $taskAll = self::all()->count();

        $percentage = round(($tasks / $taskAll) * 100);

        return $tasks . ' (' . $percentage .  '%)';
    }
}
