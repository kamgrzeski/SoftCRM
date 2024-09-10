<?php

namespace App\Services;

use App\Models\TasksModel;
use App\Queries\SystemLogsQueries;

class HelpersFncService
{
    /**
     * @return array
     */
    public function formatTasks()
    {
        $tasks = TasksModel::all()->sortBy('created_at', 0, true)->slice(0, 5);

        $arrayWithFormattedTasks = [];

        foreach ($tasks as $key => $task) {
            $nameTask = substr($task->name, 0, 70);
            $nameTask .= '[..]';

            $arrayWithFormattedTasks[$key] = [
                'id' => $task->id,
                'name' => $nameTask,
                'duration' => $task->duration,
                'created_at' => $task->created_at
            ];
        }

        return $arrayWithFormattedTasks;
    }

    /**
     * @return array
     */
    public function formatAllSystemLogs(): array
    {
        $allLogs = SystemLogsQueries::getAll();

        $tempArray = [];

        foreach ($allLogs as $key => $result)
        {
            $tempArray[$key] = [
                'id' => $result->id ?? '(not set)',
                'user_id' => $result->user_id ?? '(not set)',
                'actions' => $result->actions ?? '(not set)',
                'city' => $result->city ?? '(not set)',
                'country' => $result->country ?? '(not set)',
                'ip_address' => $result->ip_address ?? '(not set)',
                'date' => $result->date ?? '(not set)'
            ];
        }

        return $tempArray;
    }
}
