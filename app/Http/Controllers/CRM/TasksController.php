<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\TasksStoreRequest;
use App\Services\SystemLogService;
use App\Services\TasksService;
use App\Traits\Language;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;

class TasksController extends Controller
{
    use Language;

    private $systemLogs;
    private $taskService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->taskService = new TasksService();
    }

    public function processListOfTasks()
    {
        return View::make('crm.tasks.index')->with($this->taskService->loadDataAndPagination());
    }

    public function showCreateForm()
    {
        return View::make('crm.tasks.create')->with([
            'dataOfEmployees' => $this->taskService->pluckEmployees(),
            'inputText' => $this->getMessage('messages.InputText')
        ]);
    }

    public function viewTasksDetails(int $taskId)
    {
        return View::make('crm.tasks.show')
            ->with('tasks', $this->taskService->loadTask($taskId));
    }

    public function showUpdateForm(int $taskId)
    {
        return View::make('crm.tasks.edit')
            ->with([
                'tasks' => $this->taskService->loadTask($taskId),
                'employees' => $this->taskService->pluckEmployees(),
                'inputText' => $this->getMessage('messages.InputText')
            ]);
    }

    public function processCreateTasks(TasksStoreRequest $request)
    {
        if ($task = $this->taskService->execute($request->validated())) {
            $this->systemLogs->insertSystemLogs('Task has been add with id: '. $task, $this->systemLogs::successCode);
            return Redirect::to('tasks')->with('message_success', $this->getMessage('messages.SuccessTasksStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorTasksStore'));
        }
    }

    public function processUpdateTasks(Request $request, int $taskId)
    {
        if ($this->taskService->update($taskId, $request->all())) {
            return Redirect::to('tasks')->with('message_success', $this->getMessage('messages.SuccessTasksUpdate'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorTasksUpdate'));
        }
    }

    public function processDeleteTasks($taskId)
    {
        $dataOfTasks = $this->taskService->loadTask($taskId);

        if($dataOfTasks->completed == 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.CantDeleteUnompletedTask'));
        } else {
            $dataOfTasks->delete();

            $this->systemLogs->insertSystemLogs('Tasks has been deleted with id: ' . $dataOfTasks->id, $this->systemLogs::successCode);
        }

        return Redirect::to('tasks')->with('message_success', $this->getMessage('messages.SuccessTasksDelete'));
    }

    public function processSetIsActive(int $taskId, bool $value)
    {
        if ($this->taskService->loadIsActiveFunction($taskId, $value)) {
            $this->systemLogs->insertSystemLogs('Tasks has been enabled with id: ' . $taskId, $this->systemLogs::successCode);
            return Redirect::to('tasks')->with('message_success', $this->getMessage('messages.SuccessTasksActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorTasksActive'));
        }
    }

    public function completedTask(int $taskId)
    {
        if ($this->taskService->loadIsCompletedFunction($taskId, TRUE)) {
            $this->systemLogs->insertSystemLogs('Tasks has been completed with id: ' . $taskId, $this->systemLogs::successCode);
            return Redirect::back()->with('message_success', $this->getMessage('messages.TasksCompleted'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.TasksIsNotCompleted'));
        }
    }

    public function uncompletedTask(int $taskId)
    {
        if ($this->taskService->loadIsCompletedFunction($taskId, FALSE)) {
            $this->systemLogs->insertSystemLogs('Tasks has been uncompleted with id: ' . $taskId, $this->systemLogs::successCode);
            return Redirect::back()->with('message_success', $this->getMessage('messages.TasksunCompleted'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.TasksIsNotunCompleted'));
        }
    }
}
