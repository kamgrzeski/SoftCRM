<?php

namespace App\Services;

use App\Queries\TasksQueries;

/**
 * Class TasksService
 *
 * Service class for handling operations related to the TasksModel.
 */
class TasksService
{
    /**
     * Load paginated list of tasks.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function loadPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return TasksQueries::getPaginate();
    }

    /**
     * Load the count of all tasks.
     *
     * @return int
     */
    public function loadCountTasks(): int
    {
        return TasksQueries::countAll();
    }

    /**
     * Load all completed tasks with percentage.
     *
     * @return string
     */
    public function loadCompletedTasks(): string
    {
        $countCompletedTasks = TasksQueries::getCountCompleted();
        $countAllTasks = TasksQueries::countAll();

        $percentage = round(($countCompletedTasks / $countAllTasks) * 100);

        return $countCompletedTasks . ' (' . $percentage .  '%)';
    }

    /**
     * Load all uncompleted tasks with percentage.
     *
     * @return string A string representing the number of uncompleted tasks and their percentage of the total tasks.
     */
    public function loadUncompletedTasks(): string
    {
        $uncompletedTasksCount = TasksQueries::getAllUncompletedTasks();
        $countAllTasks = TasksQueries::countAll();

        $percentage = round(($uncompletedTasksCount / $countAllTasks) * 100);

        return $uncompletedTasksCount . ' (' . $percentage .  '%)';
    }
}
