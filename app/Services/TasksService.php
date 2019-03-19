<?php

namespace App\Services;

use App\Models\EmployeesModel;
use App\Models\TasksModel;

class TasksService
{
    private $tasksModel;

    public function __construct()
    {
        $this->tasksModel = new TasksModel();
    }

    public function execute(array $validateData)
    {
        return $this->tasksModel->storeTask($validateData);
    }

    public function update(int $taskId, array $validatedData)
    {
        return $this->tasksModel->updateTask($taskId, $validatedData);
    }

    public function loadTasks()
    {
        return $this->tasksModel->getTasks();
    }

    public function loadPaginate()
    {
        return $this->tasksModel->getPaginate();
    }

    public function loadTask(int $taskId)
    {
        return $this->tasksModel->getTask($taskId);
    }

    public function loadIsActiveFunction(int $taskId, bool $value)
    {
        return $this->tasksModel->setActive($taskId, $value);
    }

    public function loadIsCompletedFunction(int $taskId, bool $value)
    {
        return $this->tasksModel->setCompleted($taskId, $value);
    }

    public function pluckEmployees()
    {
        return EmployeesModel::pluck('full_name', 'id');
    }

    public function loadDataAndPagination()
    {
        $dataOfTasks = [
            'tasks' => $this->loadTasks(),
            'tasksPaginate' => $this->loadPaginate()
        ];

        return $dataOfTasks;
    }

    public function loadCountTasks()
    {
        return $this->tasksModel->countTasks() ? : 0;

    }

    public function loadCompletedTasks()
    {
        return $this->tasksModel->getAllCompletedTasks();
    }

    public function loadUncompletedTasks()
    {
        return $this->tasksModel->getAllUncompletedTasks();
    }
}