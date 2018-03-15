<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\ClientsModel;
use App\Models\CompaniesModel;
use App\Models\DealsModel;
use App\Models\Language;
use App\Models\ProjectsModel;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class ProjectsController extends Controller
{
    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataWithProjects = [
            'projects' => ProjectsModel::all()->sortByDesc('created_at'),
            'projectsPaginate' => ProjectsModel::paginate(Config::get('crm_settings.pagination_size'))
        ];

        return $dataWithProjects;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('crm.projects.index')->with($this->getDataAndPagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
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
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, ProjectsModel::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('projects/create')->with('message_danger', $validator->errors());
        } else {
            if ($project = ProjectsModel::insertRow($allInputs)) {
                SystemLogsController::insertSystemLogs('Project has been add with id: '. $project, 200);
                return Redirect::to('projects')->with('message_success', Language::getMessage('messages.SuccessProjectsStore'));
            } else {
                return Redirect::back()->with('message_success', Language::getMessage('messages.ErrorProjectsStore'));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $dataOfProjects = ProjectsModel::find($id);

        return View::make('crm.projects.show')
            ->with([
                'projects' => $dataOfProjects,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {

        $projectsDetails = ProjectsModel::find($id);
        $dataWithPluckOfClients = ClientsModel::pluck('full_name', 'id');
        $dataWithPluckOfDeals = DealsModel::pluck('name', 'id');
        $dataWithPluckOfCompanies = CompaniesModel::pluck('name', 'id');

        return View::make('crm.projects.edit')
            ->with([
                'projects' => $projectsDetails,
                'clients' => $dataWithPluckOfClients,
                'deals' => $dataWithPluckOfDeals,
                'companies' => $dataWithPluckOfCompanies
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, ProjectsModel::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if (ProjectsModel::updateRow($id, $allInputs)) {
                return Redirect::to('projects')->with('message_success', Language::getMessage('messages.SuccessProjectsStore'));
            } else {
                return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorProjectsStore'));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $projectsDetails = ProjectsModel::find($id);
        $projectsDetails->delete();

        SystemLogsController::insertSystemLogs('ProjectsModel has been deleted with id: ' . $projectsDetails->id, 200);

        return Redirect::to('projects')->with('message_success', Language::getMessage('messages.SuccessProjectsDelete'));
    }

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function isActiveFunction($id, $value)
    {
        $projectsDetails = ProjectsModel::find($id);

        if (ProjectsModel::setActive($projectsDetails->id, $value)) {
            SystemLogsController::insertSystemLogs('ProjectsModel has been enabled with id: ' . $projectsDetails->id, 200);
            return Redirect::back()->with('message_success', Language::getMessage('messages.SuccessProjectsActive'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ProjectsIsActived'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findProjectsByValue = count(ProjectsModel::trySearchProjectsByValue('full_name', $getValueInput, 10));
        $dataOfProjects = $this->getDataAndPagination();

        if (!$findProjectsByValue > 0) {
            return redirect('projects')->with('message_danger', Language::getMessage('messages.ThereIsNoProjects'));
        } else {
            $dataOfProjects += ['projects_search' => $findProjectsByValue];
            Redirect::to('projects/search')->with('message_success', 'Find ' . $findProjectsByValue . ' projects!');
        }

        return View::make('crm.projects.index')->with($dataOfProjects);
    }
}
