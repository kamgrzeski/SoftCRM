<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectsStoreRequest;
use App\Models\ClientsModel;
use App\Models\CompaniesModel;
use App\Models\DealsModel;
use App\Models\ProjectsModel;
use App\Services\ProjectsService;
use App\Services\SystemLogService;
use App\Traits\Language;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class ProjectsController extends Controller
{
    use Language;

    private $systemLogs;
    private $language;
    private $projectsModel;
    private $projectsService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->projectsModel = new ProjectsModel();
        $this->projectsService = new ProjectsService();
    }

    private function getDataAndPagination()
    {
        $dataWithProjects = [
            'projects' => $this->projectsService->getProjects(),
            'projectsPaginate' => $this->projectsService->getPagination()
        ];

        return $dataWithProjects;
    }

    public function index()
    {
        return View::make('crm.projects.index')->with(
            [
                'projects' => $this->getDataAndPagination(),
                'inputText' => $this->getMessage('messages.InputText')
            ]);
    }

    public function create()
    {
        $dataOfClients = ClientsModel::pluck('full_name', 'id');
        $dataOfCompanies = CompaniesModel::pluck('name', 'id');
        $dataOfDeals = DealsModel::pluck('name', 'id');
        return View::make('crm.projects.create')->with(
            [
                'dataOfClients' => $dataOfClients,
                'dataOfCompanies' => $dataOfCompanies,
                'dataOfDeals' => $dataOfDeals,
                'inputText' => $this->getMessage('messages.InputText')
            ]);
    }

    public function show($projectId)
    {
        return View::make('crm.projects.show')
            ->with([
                'projects' => $this->projectsService->getProject($projectId),
                'inputText' => $this->getMessage('messages.InputText')
            ]);
    }

    public function edit($projectId)
    {
        $dataWithPluckOfClients = ClientsModel::pluck('full_name', 'id');
        $dataWithPluckOfDeals = DealsModel::pluck('name', 'id');
        $dataWithPluckOfCompanies = CompaniesModel::pluck('name', 'id');

        return View::make('crm.projects.edit')
            ->with([
                'projects' => $this->projectsService->getProject($projectId),
                'clients' => $dataWithPluckOfClients,
                'deals' => $dataWithPluckOfDeals,
                'companies' => $dataWithPluckOfCompanies
            ]);
    }

    public function store(ProjectsStoreRequest $request)
    {
        if ($project = $this->projectsService->execute($request->validated())) {
            $this->systemLogs->insertSystemLogs('Project has been add with id: '. $project, 200);
            return Redirect::to('projects')->with('message_success', $this->getMessage('messages.SuccessProjectsStore'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorProjectsStore'));
        }
    }

    public function update(Request $request, int $projectId)
    {
        if ($this->projectsService->update($projectId, $request->all())) {
            return Redirect::to('projects')->with('message_success', $this->getMessage('messages.SuccessProjectsStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorProjectsStore'));
        }
    }

    public function destroy($projectId)
    {
        $projectsDetails = $this->projectsService->getProject($projectId);
        $projectsDetails->delete();

        $this->systemLogs->insertSystemLogs('ProjectsModel has been deleted with id: ' . $projectsDetails->id, 200);

        return Redirect::to('projects')->with('message_success', $this->getMessage('messages.SuccessProjectsDelete'));
    }

    public function isActiveFunction($projectId, $value)
    {
        if ($this->projectsService->loadIsActiveFunction($projectId, $value)) {
            $this->systemLogs->insertSystemLogs('ProjectsModel has been enabled with id: ' . $projectId, 200);
            return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessProjectsActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ProjectsIsActived'));
        }
    }

    public function search()
    {
        return true; // TODO
    }
}
