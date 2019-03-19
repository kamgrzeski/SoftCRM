<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\TasksStoreRequest;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;

class TasksController extends Controller
{
    public function processListOfTasks()
    {
        $collectDataForView = array_merge($this->collectedData(), $this->tasksService->loadDataAndPagination());

        return View::make('crm.tasks.index')->with($collectDataForView);
    }

    public function showCreateForm()
    {
        $collectDataForView = array_merge($this->collectedData(), ['dataOfEmployees' => $this->tasksService->pluckEmployees()]);

        return View::make('crm.tasks.create')->with($collectDataForView);
    }

    public function viewTasksDetails(int $taskId)
    {
        $collectDataForView = array_merge($this->collectedData(), ['tasks' => $this->tasksService->loadTask($taskId)]);

        return View::make('crm.tasks.show')->with($collectDataForView);
    }

    public function showUpdateForm(int $taskId)
    {
        $collectDataForView = array_merge($this->collectedData(), ['tasks' => $this->tasksService->loadTask($taskId)],
            ['employees' => $this->tasksService->pluckEmployees()]);

        return View::make('crm.tasks.edit')->with($collectDataForView);
    }

    public function processCreateTasks(TasksStoreRequest $request)
    {
        if ($task = $this->tasksService->execute($request->validated())) {
            $this->systemLogsService->insertSystemLogs('Task has been add with id: '. $task, $this->systemLogsService::successCode);
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

        if($dataOfTasks->completed == 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.CantDeleteUnompletedTask'));
        } else {
            $dataOfTasks->delete();

            $this->systemLogsService->insertSystemLogs('Tasks has been deleted with id: ' . $dataOfTasks->id, $this->systemLogsService::successCode);
        }

        return Redirect::to('tasks')->with('message_success', $this->getMessage('messages.SuccessTasksDelete'));
    }

    public function processSetIsActive(int $taskId, bool $value)
    {
        if ($this->tasksService->loadIsActiveFunction($taskId, $value)) {
            $this->systemLogsService->insertSystemLogs('Tasks has been enabled with id: ' . $taskId, $this->systemLogsService::successCode);
            return Redirect::to('tasks')->with('message_success', $this->getMessage('messages.SuccessTasksActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorTasksActive'));
        }
    }

    public function completedTask(int $taskId)
    {
        if ($this->tasksService->loadIsCompletedFunction($taskId, TRUE)) {
            $this->systemLogsService->insertSystemLogs('Tasks has been completed with id: ' . $taskId, $this->systemLogsService::successCode);
            return Redirect::back()->with('message_success', $this->getMessage('messages.TasksCompleted'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.TasksIsNotCompleted'));
        }
    }

    public function uncompletedTask(int $taskId)
    {
        if ($this->tasksService->loadIsCompletedFunction($taskId, FALSE)) {
            $this->systemLogsService->insertSystemLogs('Tasks has been uncompleted with id: ' . $taskId, $this->systemLogsService::successCode);
            return Redirect::back()->with('message_success', $this->getMessage('messages.TasksunCompleted'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.TasksIsNotunCompleted'));
        }
    }
}
