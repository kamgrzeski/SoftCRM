<?php

namespace App\Http\Controllers\CRM;

use App\Client;
use App\Companies;
use App\Deals;
use App\Projects;
use App\Http\Controllers\Controller;
use App\Language;
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
            'projects' => Projects::all(),
            'projectsPaginate' => Projects::paginate(Config::get('crm_settings.pagination_size'))
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
        $dataOfClients = Client::pluck('full_name', 'id');
        $dataOfCompanies = Companies::pluck('name', 'id');
        $dataOfDeals = Deals::pluck('name', 'id');
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

        $validator = Validator::make($allInputs, Projects::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('projects/create')->with('message_danger', $validator->errors());
        } else {
            if (Projects::insertRow($allInputs)) {
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
        $dataOfProjects = Projects::find($id);

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
        $projectsDetails = Projects::find($id);

        return View::make('crm.projects.edit')
            ->with('projects', $projectsDetails);
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

        $validator = Validator::make($allInputs, Projects::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if (Projects::updateRow($id, $allInputs)) {
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
     */
    public function destroy($id)
    {
        $projectsDetails = Projects::find($id);
        $projectsDetails->delete();

        return Redirect::to('projects')->with('message_success', Language::getMessage('messages.SuccessProjectsDelete'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function enable($id)
    {
        $projectsDetails = Projects::find($id);

        if (Projects::setActive($projectsDetails->id, TRUE)) {
            return Redirect::back()->with('message_success', Language::getMessage('messages.SuccessProjectsActive'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ProjectsIsActived'));
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function disable($id)
    {
        $projectsDetails = Projects::find($id);

        if (Projects::setActive($projectsDetails->id, FALSE)) {
            return Redirect::back()->with('message_success', Language::getMessage('messages.ProjectsIsNowDeactivated'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ProjectsIsDeactivated'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findProjectsByValue = count(Projects::trySearchProjectsByValue('full_name', $getValueInput, 10));
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
