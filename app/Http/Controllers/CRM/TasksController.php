<?php

namespace App\Http\Controllers\CRM;

use App\Employees;
use App\Tasks;
use App\Http\Controllers\Controller;
use App\Language;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class TasksController extends Controller
{
    /**
     * @return array
     */
    private function getDataAndPagination() {
        $dataOfTasks = [
            'tasks' => Tasks::all(),
            'tasksPaginate' => Tasks::paginate(Config::get('crm_settings.pagination_size'))
        ];

        return $dataOfTasks;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('crm.tasks.index')->with($this->getDataAndPagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $dataOfEmployees = Employees::pluck('full_name', 'id');
        return View::make('crm.tasks.create', compact('dataOfEmployees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, Tasks::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('tasks/create')->with('message_danger', $validator->errors());
        } else {
            if (Tasks::insertRow($allInputs)) {
                return Redirect::to('tasks')->with('message_success', Language::getMessage('messages.SuccessTasksStore'));
            } else {
                return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorTasksStore'));
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
        $dataOfTasks = Tasks::find($id);

        return View::make('crm.tasks.show')
            ->with('tasks', $dataOfTasks);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $dataOfTasks = Tasks::find($id);
        $dataWithPluckOfEmployees = Employees::pluck('full_name', 'id');
        return View::make('crm.tasks.edit')
            ->with([
                'tasks' => $dataOfTasks,
                'employees' => $dataWithPluckOfEmployees
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

        $validator = Validator::make($allInputs, Tasks::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if (Tasks::updateRow($id, $allInputs)) {
                return Redirect::to('tasks')->with('message_success', Language::getMessage('messages.SuccessTasksUpdate'));
            } else {
                return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorTasksUpdate'));
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
        $dataOfTasks = Tasks::find($id);
        $dataOfTasks->delete();

        return Redirect::to('tasks')->with('message_success', Language::getMessage('messages.SuccessTasksDelete'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function enable($id)
    {
        $dataOfTasks = Tasks::find($id);

        if (Tasks::setActive($dataOfTasks->id, TRUE)) {
            return Redirect::back()->with('message_success', Language::getMessage('messages.SuccessTasksActive'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorTasksActive'));
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function disable($id)
    {
        $dataOfTasks = Tasks::find($id);

        if (Tasks::setActive($dataOfTasks->id, FALSE)) {
            return Redirect::back()->with('message_success', Language::getMessage('messages.TasksIsNowDeactivated'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.TasksIsDeactivated'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findTasksByValue = count(Tasks::trySearchTasksByValue('name', $getValueInput, 10));
        $dataOfTasks = $this->getDataAndPagination();

        if(!$findTasksByValue > 0 ) {
            return redirect('tasks')->with('message_danger', Language::getMessage('messages.ThereIsNoTasks'));
        } else {
            $dataOfTasks += ['tasks_search' => $findTasksByValue];
            Redirect::to('tasks/search')->with('message_success', 'Find '.$findTasksByValue.' deals!');
        }

        return View::make('crm.tasks.index')->with($dataOfTasks);
    }
}
