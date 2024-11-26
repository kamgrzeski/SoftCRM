<?php

namespace App\Queries;

use App\Models\Setting;
use App\Models\Task;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class TasksQueries
 *
 * Query class for handling operations related to the TasksModel.
 */
class TaskQueries
{
    /**
     * Get paginated list of tasks.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Task::orderByDesc('id')
            ->paginate(Setting::where('key', 'pagination_size')
                ->get()->last()->value);
    }

    /**
     * Get the count of all tasks.
     *
     * @return int
     */
    public static function countAll(): int
    {
        return Task::count();
    }

    /**
     * Get the count of all completed tasks.
     *
     * @return int
     */
    public static function getCountCompleted(): int
    {
        return Task::where('completed', '=', 1)
            ->count();
    }

    /**
     * Get the count of all uncompleted tasks.
     *
     * @return int
     */
    public static function getAllUncompletedTasks(): int
    {
        return Task::where('completed', '=', 0)
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
        return Task::where('employee_id', $id)->get()->count();
    }

    /**
     *  Get the count of tasks assigned to a specific project.
     *
     * @return Collection
     */
    public static function getAllForFormat(): \Illuminate\Support\Collection
    {
        return Task::all()->sortBy('created_at', 0, true)->slice(0, 5);
    }

    /**
     * Format tasks for display.
     *
     * @return array
     */
    public static function formatTasks(): array
    {
        return Task::get()->map(function ($task) {
            $nameTask = Str::limit($task->name, 70);
            return [
                'id' => $task->id,
                'name' => $nameTask,
                'duration' => $task->duration,
                'created_at' => $task->created_at,
            ];
        })->toArray();
    }
}
