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

    public function getTasks()
    {
        return TasksModel::all()->sortByDesc('created_at');
    }

    public function getPaginate()
    {
        return TasksModel::paginate(Config::get('crm_settings.pagination_size'));
    }

    public function execute($allInputs)
    {
        return $this->tasksModel->insertRow($allInputs);
    }

    public function getTask(int $id)
    {
        return TasksModel::find($id);
    }

    public function update(int $id, $allInputs)
    {
        return $this->tasksModel->updateRow($id, $allInputs);
    }

    public function loadIsActiveFunction($id, $value)
    {
        return $this->tasksModel->setActive($id, $value);
    }

    public function loadIsCompletedFunction($id, $value)
    {
        return $this->tasksModel->setCompleted($id, $value);
    }
}