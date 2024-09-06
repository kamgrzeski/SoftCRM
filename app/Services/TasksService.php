<?php

namespace App\Services;

use App\Models\TasksModel;

class TasksService
{
    private TasksModel $tasksModel;

    public function __construct()
    {
        $this->tasksModel = new TasksModel();
    }

    public function loadPaginate()
    {
        return $this->tasksModel->getPaginate();
    }

    public function loadCountTasks()
    {
        return $this->tasksModel->countTasks();
    }

    public function loadCompletedTasks()
    {
        return $this->tasksModel->getAllCompletedTasks();
    }

    public function loadUncompletedTasks()
    {
        $data = $this->tasksModel->getAllUncompletedTasks();

        $percentage = round(($data['tasks'] / $data['all']) * 100);

        return $data['tasks'] . ' (' . $percentage .  '%)';
    }
}
