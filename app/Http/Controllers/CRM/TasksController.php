<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\TasksStoreRequest;
use App\Models\EmployeesModel;
use App\Models\TasksModel;
use App\Services\SystemLogService;
use App\Services\TasksService;
use App\Traits\Language;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class TasksController extends Controller
{
    use Language;

    private $systemLogs;
    private $taskModel;
    private $taskService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->taskModel = new TasksModel();
        $this->taskService = new TasksService();
    }

    private function getDataAndPagination()
    {
        $dataOfTasks = [
            'tasks' => $this->taskService->getTasks(),
            'tasksPaginate' => $this->taskService->getPaginate()
        ];

        return $dataOfTasks;
    }

    public function index()
    {
        return View::make('crm.tasks.index')->with($this->getDataAndPagination());
    }

    public function create()
    {
        $dataOfEmployees = EmployeesModel::pluck('full_name', 'id');

        return View::make('crm.tasks.create')->with([
            'dataOfEmployees' => $dataOfEmployees,
            'inputText' => $this->getMessage('messages.InputText')
        ]);
    }

    public function show($taskId)
    {
        return View::make('crm.tasks.show')
            ->with('tasks', $this->taskService->getTask($taskId));
    }

    public function edit($taskId)
    {
        $dataWithPluckOfEmployees = EmployeesModel::pluck('full_name', 'id');

        return View::make('crm.tasks.edit')
            ->with([
                'tasks' => $this->taskService->getTask($taskId),
                'employees' => $dataWithPluckOfEmployees
            ]);
    }

    public function store(TasksStoreRequest $request)
    {
        if ($task = $this->taskService->execute($request->validated())) {
            $this->systemLogs->insertSystemLogs('Task has been add with id: '. $task, $this->systemLogs::successCode);
            return Redirect::to('tasks')->with('message_success', $this->getMessage('messages.SuccessTasksStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorTasksStore'));
        }
    }

    public function update(Request $request, int $taskId)
    {
        if ($this->taskService->update($taskId, $request->all())) {
            return Redirect::to('tasks')->with('message_success', $this->getMessage('messages.SuccessTasksUpdate'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorTasksUpdate'));
        }
    }

    public function destroy($taskId)
    {
        $dataOfTasks = $this->taskService->getTask($taskId);

        if($dataOfTasks->completed == 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.CantDeleteUnompletedTask'));
        } else {
            $dataOfTasks->delete();

            $this->systemLogs->insertSystemLogs('Tasks has been deleted with id: ' . $dataOfTasks->id, $this->systemLogs::successCode);

        }

        return Redirect::to('tasks')->with('message_success', $this->getMessage('messages.SuccessTasksDelete'));
    }

    public function isActiveFunction($taskId, $value)
    {
        if ($this->taskService->loadIsActiveFunction($taskId, $value)) {
            $this->systemLogs->insertSystemLogs('Tasks has been enabled with id: ' . $taskId, $this->systemLogs::successCode);
            return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessTasksActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorTasksActive'));
        }
    }

    public function search()
    {
        return true; // TODO
    }

    public function completedTask($taskId)
    {
        if ($this->taskService->loadIsCompletedFunction($taskId, TRUE)) {
            $this->systemLogs->insertSystemLogs('Tasks has been completed with id: ' . $taskId, $this->systemLogs::successCode);
            return Redirect::back()->with('message_success', $this->getMessage('messages.TasksCompleted'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.TasksIsNotCompleted'));
        }
    }

    public function uncompletedTask($taskId)
    {
        if ($this->taskService->loadIsCompletedFunction($taskId, FALSE)) {
            $this->systemLogs->insertSystemLogs('Tasks has been uncompleted with id: ' . $taskId, $this->systemLogs::successCode);
            return Redirect::back()->with('message_success', $this->getMessage('messages.TasksunCompleted'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.TasksIsNotunCompleted'));
        }
    }
}
