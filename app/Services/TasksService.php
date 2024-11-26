<?php

namespace App\Services;

use App\Queries\TaskQueries;

/**
 * Class TasksService
 *
 * Service class for handling operations related to the TasksModel.
 */
class TasksService
{
    /**
     * Load all completed tasks with percentage.
     *
     * @return string
     */
    public function loadCompletedTasks(): string
    {
        $countCompletedTasks = TaskQueries::getCountCompleted();
        $countAllTasks = TaskQueries::countAll();

        if ($countAllTasks === 0) {
            return '0 (0%)';
        }

        $percentage = round(($countCompletedTasks / $countAllTasks) * 100);

        return "{$countCompletedTasks} ({$percentage}%)";
    }

    /**
     * Load all uncompleted tasks with percentage.
     *
     * @return string A string representing the number of uncompleted tasks and their percentage of the total tasks.
     */
    public function loadUncompletedTasks(): string
    {
        $uncompletedTasksCount = TaskQueries::getAllUncompletedTasks();
        $countAllTasks = TaskQueries::countAll();

        if ($countAllTasks === 0) {
            return '0 (0%)';
        }

        $percentage = round(($uncompletedTasksCount / $countAllTasks) * 100);

        return "{$uncompletedTasksCount} ({$percentage}%)";
    }
}
