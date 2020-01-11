<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\TasksStoreRequest;
use App\Services\SystemLogService;
use App\Services\TasksService;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;

class TasksController extends Controller
{
    private $tasksService;
    private $systemLogsService;

    public function __construct()
    {
        $this->middleware('auth');

        $this->tasksService = new TasksService();
        $this->systemLogsService = new SystemLogService();
    }

    public function processListOfTasks()
    {
        return View::make('crm.tasks.index')->with(
            [
                'tasks' => $this->tasksService->loadTasks(),
                'tasksPaginate' => $this->tasksService->loadPaginate()
            ]);
    }

    public function showCreateForm()
    {
        return View::make('crm.tasks.create')->with(['dataOfEmployees' => $this->tasksService->pluckEmployees()]);
    }

    public function viewTasksDetails(int $taskId)
    {
        return View::make('crm.tasks.show')->with(['tasks' => $this->tasksService->loadTask($taskId)]);
    }

    public function showUpdateForm(int $taskId)
    {
        return View::make('crm.tasks.edit')->with(
            [
                'tasks' => $this->tasksService->loadTask($taskId),
                'employees' => $this->tasksService->pluckEmployees()
            ]
        );
    }

    public function processCreateTasks(TasksStoreRequest $request)
    {
        if ($task = $this->tasksService->execute($request->validated(), $this->getAdminId())) {
            $this->systemLogsService->loadInsertSystemLogs('Task has been add with id: ' . $task, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('tasks')->with('message_success', $this->getMessage('messages.SuccessTasksStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorTasksStore'));
        }
    }

    public function processUpdateTasks(Request $request, int $taskId)
    {
        if ($this->tasksService->update($taskId, $request->all())) {
            return Redirect::to('tasks')->with('message_success', $this->getMessage('messages.SuccessTasksUpdate'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorTasksUpdate'));
        }
    }

    public function processDeleteTasks($taskId)
    {
        $dataOfTasks = $this->tasksService->loadTask($taskId);

        if ($dataOfTasks->completed == 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.CantDeleteUnompletedTask'));
        } else {
            $dataOfTasks->delete();

            $this->systemLogsService->loadInsertSystemLogs('Tasks has been deleted with id: ' . $dataOfTasks->id, $this->systemLogsService::successCode, $this->getAdminId());
        }

        return Redirect::to('tasks')->with('message_success', $this->getMessage('messages.SuccessTasksDelete'));
    }

    public function processSetIsActive(int $taskId, bool $value)
    {
        if ($this->tasksService->loadIsActiveFunction($taskId, $value)) {
            $this->systemLogsService->loadInsertSystemLogs('Tasks has been enabled with id: ' . $taskId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('tasks')->with('message_success', $this->getMessage('messages.SuccessTasksActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorTasksActive'));
        }
    }

    public function completedTask(int $taskId)
    {
        if ($this->tasksService->loadIsCompletedFunction($taskId, TRUE)) {
            $this->systemLogsService->loadInsertSystemLogs('Tasks has been completed with id: ' . $taskId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::back()->with('message_success', $this->getMessage('messages.TasksCompleted'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.TasksIsNotCompleted'));
        }
    }

    public function uncompletedTask(int $taskId)
    {
        if ($this->tasksService->loadIsCompletedFunction($taskId, FALSE)) {
            $this->systemLogsService->loadInsertSystemLogs('Tasks has been uncompleted with id: ' . $taskId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::back()->with('message_success', $this->getMessage('messages.TasksunCompleted'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.TasksIsNotunCompleted'));
        }
    }
}
