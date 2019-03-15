<?php

namespace App\Services;

use App\Models\ProjectsModel;
use Config;

class ProjectsService
{
    private $projectsModel;

    public function __construct()
    {
        $this->projectsModel = new ProjectsModel();
    }

    public function getProjects()
    {
        return $this->projectsModel::all()->sortByDesc('created_at');
    }

    public function getPagination()
    {
        return $this->projectsModel::paginate(Config::get('crm_settings.pagination_size'));
    }

    public function execute($allInputs)
    {
        return $this->projectsModel->insertRow($allInputs);
    }

    public function getProject(int $id)
    {
        return $this->projectsModel::find($id);;
    }

    public function update($id, $allInputs)
    {
        return $this->projectsModel->updateRow($id, $allInputs);
    }

    public function loadIsActiveFunction($id, $value)
    {
        return $this->projectsModel->setActive($id, $value);
    }
}