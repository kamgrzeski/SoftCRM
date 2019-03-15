<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class TasksModel extends Model
{
    protected $table = 'tasks';

    public function employees()
    {
        return $this->belongsTo(EmployeesModel::class, 'employee_id');
    }

    public function insertRow($allInputs)
    {
        return self::insertGetId(
            [
                'name' => $allInputs['name'],
                'employee_id' => $allInputs['employee_id'],
                'duration' => $allInputs['duration'],
                'is_active' => 1,
                'created_at' => Carbon::now()
            ]
        );
    }

    public function updateRow($id, $allInputs)
    {
        return self::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'employee_id' => $allInputs['employee_id'],
                'duration' => $allInputs['duration'],
                'is_active' => 1,
                'updated_at' => Carbon::now()
            ]);
    }

    public function setActive($id, $activeType)
    {
        $findTasksById = self::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findTasksById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function setCompleted($id, $completeType)
    {
        $findTasksById = self::where('id', '=', $id)->update(
            [
                'completed' => $completeType
            ]);

        if ($findTasksById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function countTasks()
    {
        return self::all()->count();
    }

    public static function trySearchTasksByValue($type, $value, $paginationLimit = 10)
    {
        return self::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    public static function getAllCompletedAndUncompletedTasks($isCompleted)
    {
        $tasks = self::where('completed', '=', $isCompleted)->count();

        $taskAll = self::all()->count();

        $percentage = round(($tasks / $taskAll) * 100);

        return $tasks . ' (' . $percentage .  '%)';
    }
}
