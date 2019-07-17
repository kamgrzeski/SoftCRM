<?php

namespace App\Services;

use App\Models\TasksModel;

class TasksService
{
    private $tasksModel;

    public function __construct()
    {
        $this->tasksModel = new TasksModel();
    }

    public function loadCountTasks()
    {
        return $this->tasksModel->getCountTasks();
    }

    public function loadUncompletedTasks()
    {
        return $this->tasksModel->getAllUncompletedTasks();

    }

    public function loadCompletedTasks()
    {
        return $this->tasksModel->getAllCompletedTasks();
    }

    public function loadTasks()
    {
        return $this->tasksModel->getTasks();
    }
}