<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Services\SystemLogService;
use App\Services\TasksService;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;

class TasksController extends Controller
{
    private TasksService $tasksService;
    private SystemLogService $systemLogsService;

    public function __construct(TasksService $tasksService, SystemLogService $systemLogService)
    {
        $this->middleware(SystemEnums::middleWareAuth);

        $this->tasksService = $tasksService;
        $this->systemLogsService = $systemLogService;
    }

    public function processRenderCreateForm()
    {
        return View::make('crm.tasks.create')->with(['dataOfEmployees' => $this->tasksService->pluckEmployees()]);
    }

    public function processListOfTasks()
    {
        return View::make('crm.tasks.index')->with(
            [
                'tasks' => $this->tasksService->loadTasks(),
                'tasksPaginate' => $this->tasksService->loadPaginate()
            ]);
    }

    public function processShowTasksDetails(int $taskId)
    {
        return View::make('crm.tasks.show')->with(['task' => $this->tasksService->loadTask($taskId)]);
    }

    public function processRenderUpdateForm(int $taskId)
    {
        return View::make('crm.tasks.edit')->with(
            [
                'task' => $this->tasksService->loadTask($taskId),
                'employees' => $this->tasksService->pluckEmployees()
            ]
        );
    }

    public function processStoreTask(TaskStoreRequest $request)
    {
        $storedTaskId = $this->tasksService->execute($request->validated(), $this->getAdminId());

        if ($storedTaskId) {
            $this->systemLogsService->loadInsertSystemLogs('Task has been add with id: ' . $storedTaskId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('tasks')->with('message_success', $this->getMessage('messages.SuccessTasksStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorTasksStore'));
        }
    }

    public function processUpdateTask(TaskUpdateRequest $request, int $taskId)
    {
        if ($this->tasksService->update($taskId, $request->validated())) {
            return Redirect::to('tasks')->with('message_success', $this->getMessage('messages.SuccessTasksUpdate'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorTasksUpdate'));
        }
    }

    public function processDeleteTask(int $taskId)
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

    public function processTaskSetIsActive(int $taskId, bool $value)
    {
        if ($this->tasksService->loadIsActiveFunction($taskId, $value)) {
            $this->systemLogsService->loadInsertSystemLogs('Tasks has been enabled with id: ' . $taskId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('tasks')->with('message_success', $this->getMessage('messages.SuccessTasksActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorTasksActive'));
        }
    }

    public function processSetTaskToCompleted(int $taskId)
    {
        if ($this->tasksService->loadIsCompletedFunction($taskId, TRUE)) {
            $this->systemLogsService->loadInsertSystemLogs('Tasks has been completed with id: ' . $taskId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::back()->with('message_success', $this->getMessage('messages.TasksCompleted'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.TasksIsNotCompleted'));
        }
    }

    public function processSetTaskToUnCompleted(int $taskId)
    {
        if ($this->tasksService->loadIsCompletedFunction($taskId, FALSE)) {
            $this->systemLogsService->loadInsertSystemLogs('Tasks has been uncompleted with id: ' . $taskId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::back()->with('message_success', $this->getMessage('messages.TasksunCompleted'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.TasksIsNotunCompleted'));
        }
    }
}
