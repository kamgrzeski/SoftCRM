<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TasksModel extends Model
{
    use SoftDeletes;

    protected $table = 'tasks';

    public function getCountTasks()
    {
        return $this->all()->count();
    }

    public function getAllCompletedTasks()
    {
        $tasks = self::where('completed', '=', 1)->count();

        $taskAll = self::all()->count();

        $percentage = round(($tasks / $taskAll) * 100);

        return $tasks . ' (' . $percentage .  '%)';
    }

    public function getAllUncompletedTasks()
    {
        $tasks = self::where('completed', '=', 0)->count();

        $taskAll = self::all()->count();

        $percentage = round(($tasks / $taskAll) * 100);

        return $tasks . ' (' . $percentage .  '%)';
    }

    public function getTasks()
    {
        $tasks = $this->all()->sortBy('created_at', 0, true)->slice(0, 5);
        $arrayWithFormattedTasks = [];

        foreach ($tasks as $key => $task) {
            $nameTask = substr($task->name, 0, 70);
            $nameTask .= '[..]';

            $arrayWithFormattedTasks[$key] = [
                'id' => $task->id,
                'name' => $nameTask,
                'duration' => $task->duration,
                'created_at' => $task->created_at->diffForHumans()
            ];
        }

        return $arrayWithFormattedTasks;
    }
}