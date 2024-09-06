<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Jobs\StoreSystemLogJob;
use App\Jobs\Task\StoreTaskJob;
use App\Jobs\Task\UpdateTaskJob;
use App\Models\TasksModel;
use App\Services\EmployeesService;
use App\Services\SystemLogService;
use App\Services\TasksService;

class TasksController extends Controller
{
    private TasksService $tasksService;
    private SystemLogService $systemLogsService;
    private EmployeesService $employeesService;

    public function __construct(TasksService $tasksService, SystemLogService $systemLogService, EmployeesService $employeesService)
    {
        $this->middleware(SystemEnums::middleWareAuth);

        $this->tasksService = $tasksService;
        $this->systemLogsService = $systemLogService;
        $this->employeesService = $employeesService;
    }

    public function processRenderCreateForm()
    {
        return view('crm.tasks.create')->with(['dataOfEmployees' => $this->employeesService->loadEmployees(true)]);
    }

    public function processListOfTasks()
    {
        return view('crm.tasks.index')->with(
            [
                'tasksPaginate' => $this->tasksService->loadPaginate()
            ]);
    }

    public function processShowTasksDetails(TasksModel $task)
    {
        return view('crm.tasks.show')->with(['task' => $task]);
    }

    public function processRenderUpdateForm(TasksModel $task)
    {
        return view('crm.tasks.edit')->with(
            [
                'task' => $task,
                'employees' => $this->employeesService->loadEmployees()
            ]
        );
    }

    public function processStoreTask(TaskStoreRequest $request)
    {
        $this->dispatchSync(new StoreTaskJob($request->validated(), auth()->user()));

        $this->dispatchSync(new StoreSystemLogJob('Task has been added.', $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('tasks')->with('message_success', $this->getMessage('messages.task_store'));
    }

    public function processUpdateTask(TaskUpdateRequest $request, TasksModel $task)
    {
        $this->dispatchSync(new UpdateTaskJob($request->validated(), $task));

        return redirect()->to('tasks')->with('message_success', $this->getMessage('messages.task_update'));
    }

    public function processDeleteTask(TasksModel $task)
    {
        if (! $task->completed) {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.task_uncompleted'));
        }

        // Delete task.
        $task->delete();

        $this->dispatchSync(new StoreSystemLogJob('Tasks has been deleted with id: ' . $task->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('tasks')->with('message_success', $this->getMessage('messages.task_delete'));
    }

    public function processTaskSetIsActive(TasksModel $task, bool $value)
    {
        $this->dispatchSync(new UpdateTaskJob(['is_active' => $value], $task));

        $this->dispatchSync(new StoreSystemLogJob('Tasks has been enabled with id: ' . $task->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('tasks')->with('message_success', $this->getMessage('messages.task_update'));
    }

    public function processSetTaskToCompleted(TasksModel $task)
    {
        $this->dispatchSync(new UpdateTaskJob(['completed' => true], $task));

        $this->dispatchSync(new StoreSystemLogJob('Tasks has been completed with id: ' . $task->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->back()->with('message_success', $this->getMessage('messages.task_completed'));
    }
}
