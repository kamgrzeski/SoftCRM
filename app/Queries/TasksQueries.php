<?php

namespace App\Queries;

use App\Models\SettingsModel;
use App\Models\TasksModel;

/**
 * Class TasksQueries
 *
 * Query class for handling operations related to the TasksModel.
 */
class TasksQueries
{
    /**
     * Get paginated list of tasks.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return TasksModel::orderByDesc('id')
            ->paginate(SettingsModel::where('key', 'pagination_size')
                ->get()->last()->value);
    }

    /**
     * Get the count of all tasks.
     *
     * @return int
     */
    public static function countAll(): int
    {
        return TasksModel::count();
    }

    /**
     * Get the count of all completed tasks.
     *
     * @return int
     */
    public static function getCountCompleted(): int
    {
        return TasksModel::where('completed', '=', 1)
            ->count();
    }

    /**
     * Get the count of all uncompleted tasks.
     *
     * @return int
     */
    public static function getAllUncompletedTasks(): int
    {
        return TasksModel::where('completed', '=', 0)
            ->count();
    }

    /**
     * Get the count of tasks assigned to a specific employee.
     *
     * @param mixed $id The ID of the employee.
     * @return int
     */
    public static function getEmployeesTaskCount(mixed $id): int
    {
        return TasksModel::where('employee_id', $id)->get()->count();
    }
}
