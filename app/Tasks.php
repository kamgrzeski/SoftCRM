<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return Tasks::insert(
            [
                'name' => $allInputs['name'],
                'employee_id' => $allInputs['employee_id'],
                'is_active' => 1
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
                'is_active' => 1
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
}
