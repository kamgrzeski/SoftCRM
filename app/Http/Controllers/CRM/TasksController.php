<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\EmployeesModel;
use App\Models\Language;
use App\Models\TasksModel;
use App\Services\SystemLogService;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class TasksController extends Controller
{
    private $systemLogs;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
    }

    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataOfTasks = [
            'tasks' => TasksModel::all()->sortByDesc('created_at'),
            'tasksPaginate' => TasksModel::paginate(Config::get('crm_settings.pagination_size'))
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
        $dataOfEmployees = EmployeesModel::pluck('full_name', 'id');
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

        $validator = Validator::make($allInputs, TasksModel::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('tasks/create')->with('message_danger', $validator->errors());
        } else {
            if ($task = TasksModel::insertRow($allInputs)) {
                $this->systemLogs->insertSystemLogs('Task has been add with id: '. $task, 200);
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
        $dataOfTasks = TasksModel::find($id);

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
        $dataOfTasks = TasksModel::find($id);
        $dataWithPluckOfEmployees = EmployeesModel::pluck('full_name', 'id');
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

        $validator = Validator::make($allInputs, TasksModel::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if (TasksModel::updateRow($id, $allInputs)) {
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
     * @throws \Exception
     */
    public function destroy($id)
    {
        $dataOfTasks = TasksModel::find($id);
        if($dataOfTasks->completed == 0) {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.CantDeleteUnompletedTask'));
        } else {
            $dataOfTasks->delete();

            $this->systemLogs->insertSystemLogs('Tasks has been deleted with id: ' . $dataOfTasks->id, 200);

        }

        return Redirect::to('tasks')->with('message_success', Language::getMessage('messages.SuccessTasksDelete'));
    }

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function isActiveFunction($id, $value)
    {
        $dataOfTasks = TasksModel::find($id);

        if (TasksModel::setActive($dataOfTasks->id, $value)) {
            $this->systemLogs->insertSystemLogs('Tasks has been enabled with id: ' . $dataOfTasks->id, 200);
            return Redirect::back()->with('message_success', Language::getMessage('messages.SuccessTasksActive'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorTasksActive'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findTasksByValue = count(TasksModel::trySearchTasksByValue('name', $getValueInput, 10));
        $dataOfTasks = $this->getDataAndPagination();

        if (!$findTasksByValue > 0) {
            return redirect('tasks')->with('message_danger', Language::getMessage('messages.ThereIsNoTasks'));
        } else {
            $dataOfTasks += ['tasks_search' => $findTasksByValue];
            Redirect::to('tasks/search')->with('message_success', 'Find ' . $findTasksByValue . ' deals!');
        }

        return View::make('crm.tasks.index')->with($dataOfTasks);
    }

    public function completedTask($id)
    {
        $dataOfTasks = TasksModel::find($id);

        if (TasksModel::setCompleted($dataOfTasks->id, TRUE)) {
            $this->systemLogs->insertSystemLogs('Tasks has been completed with id: ' . $dataOfTasks->id, 200);
            return Redirect::back()->with('message_success', Language::getMessage('messages.TasksCompleted'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.TasksIsNotCompleted'));
        }
    }



    public function uncompletedTask($id)
    {
        $dataOfTasks = TasksModel::find($id);

        if (TasksModel::setCompleted($dataOfTasks->id, FALSE)) {
            $this->systemLogs->insertSystemLogs('Tasks has been uncompleted with id: ' . $dataOfTasks->id, 200);
            return Redirect::back()->with('message_success', Language::getMessage('messages.TasksunCompleted'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.TasksIsNotunCompleted'));
        }
    }
}
