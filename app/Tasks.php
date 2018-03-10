<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Tasks extends Model
{
    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return Tasks::insertGetId(
            [
                'name' => $allInputs['name'],
                'employee_id' => $allInputs['employee_id'],
                'duration' => $allInputs['duration'],
                'is_active' => 1,
                'created_at' => Carbon::now()
            ]
        );
    }

    /**
     * @param $id
     * @param $allInputs
     * @return mixed
     */
    public static function updateRow($id, $allInputs)
    {
        return Tasks::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'employee_id' => $allInputs['employee_id'],
                'duration' => $allInputs['duration'],
                'is_active' => 1,
                'updated_at' => Carbon::now()
            ]);
    }

    /**
     * @param $rulesType
     * @return array
     */
    public static function getRules($rulesType)
    {
        switch ($rulesType) {
            case 'STORE':
                return [
                    'name' => 'required',
                    'employee_id' => 'required',
                    'duration' => 'required'
                ];
        }
    }

    /**
     * @param $id
     * @param $activeType
     * @return bool
     */
    public static function setActive($id, $activeType)
    {
        $findTasksById = Tasks::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findTasksById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @param $id
     * @param $completeType
     * @return bool
     * @internal param $activeType
     */
    public static function setCompleted($id, $completeType)
    {
        $findTasksById = Tasks::where('id', '=', $id)->update(
            [
                'completed' => $completeType
            ]);

        if ($findTasksById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return int
     */
    public static function countTasks()
    {
        return count(Tasks::get());
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function trySearchTasksByValue($type, $value, $paginationLimit = 10)
    {
        return Tasks::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employees()
    {
        return $this->belongsTo(Employees::class, 'employee_id');
    }

    /**
     * @param $isCompleted
     * @return mixed
     */
    public static function getAllCompletedAndUncompletedTasks($isCompleted)
    {
        $tasks = Tasks::where('completed', '=', $isCompleted)->count();

        return $tasks;
    }
}
