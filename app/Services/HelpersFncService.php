<?php

namespace App\Services;

use App\Models\SystemLogsModel;
use App\Models\TasksModel;

class HelpersFncService
{
    /**
     * @return array
     */
    public static function getPrioritySize()
    {
        $sizeFromConfig = config('crm_settings.priority_size');
        $arrayFromIteration = [];

        for ($i = 1; $i <= $sizeFromConfig; $i++) {
            $arrayFromIteration[] = $i;
        }
        return $arrayFromIteration;
    }

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
    public function formatAllSystemLogs()
    {
        $allLogs = SystemLogsModel::all();
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

        $formatLogs = $tempArray;

        return $formatLogs;
    }
}
