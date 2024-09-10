<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Jobs\StoreSystemLogJob;
use App\Jobs\Task\StoreTaskJob;
use App\Jobs\Task\UpdateTaskJob;
use App\Models\TasksModel;
use App\Services\EmployeesService;
use App\Services\TasksService;

/**
 * Class TasksController
 *
 * Controller for handling task-related operations in the CRM.
 */
class TasksController extends Controller
{
    private TasksService $tasksService;
    private EmployeesService $employeesService;

    /**
     * TasksController constructor.
     *
     * @param TasksService $tasksService
     * @param EmployeesService $employeesService
     */
    public function __construct(TasksService $tasksService, EmployeesService $employeesService)
    {
        $this->middleware(self::MIDDLEWARE_AUTH);

        $this->tasksService = $tasksService;
        $this->employeesService = $employeesService;
    }

    /**
     * Render the form for creating a new task record.
     *
     * @return \Illuminate\View\View
     */
    public function processRenderCreateForm(): \Illuminate\View\View
    {
        return view('crm.tasks.create')->with(['dataOfEmployees' => $this->employeesService->loadEmployees(true)]);
    }

    /**
     * List all task records with pagination.
     *
     * @return \Illuminate\View\View
     */
    public function processListOfTasks(): \Illuminate\View\View
    {
        return view('crm.tasks.index')->with([
            'tasksPaginate' => $this->tasksService->loadPaginate()
        ]);
    }

    /**
     * Show the details of a specific task record.
     *
     * @param TasksModel $task
     * @return \Illuminate\View\View
     */
    public function processShowTasksDetails(TasksModel $task): \Illuminate\View\View
    {
        return view('crm.tasks.show')->with(['task' => $task]);
    }

    /**
     * Render the form for updating an existing task record.
     *
     * @param TasksModel $task
     * @return \Illuminate\View\View
     */
    public function processRenderUpdateForm(TasksModel $task): \Illuminate\View\View
    {
        return view('crm.tasks.edit')->with([
            'task' => $task,
            'employees' => $this->employeesService->loadEmployees()
        ]);
    }

    /**
     * Store a new task record.
     *
     * @param TaskStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processStoreTask(TaskStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->dispatchSync(new StoreTaskJob($request->validated(), auth()->user()));

        $this->dispatchSync(new StoreSystemLogJob('Task has been added.', 201, auth()->user()));

        return redirect()->to('tasks')->with('message_success', $this->getMessage('messages.task_store'));
    }

    /**
     * Update an existing task record.
     *
     * @param TaskUpdateRequest $request
     * @param TasksModel $task
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processUpdateTask(TaskUpdateRequest $request, TasksModel $task): \Illuminate\Http\RedirectResponse
    {
        $this->dispatchSync(new UpdateTaskJob($request->validated(), $task));

        return redirect()->to('tasks')->with('message_success', $this->getMessage('messages.task_update'));
    }

    /**
     * Delete a task record.
     *
     * @param TasksModel $task
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processDeleteTask(TasksModel $task): \Illuminate\Http\RedirectResponse
    {
        if (! $task->completed) {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.task_uncompleted'));
        }

        // Delete task.
        $task->delete();

        $this->dispatchSync(new StoreSystemLogJob('Tasks has been deleted with id: ' . $task->id, 201, auth()->user()));

        return redirect()->to('tasks')->with('message_success', $this->getMessage('messages.task_delete'));
    }

    /**
     * Set the active status of a task record.
     *
     * @param TasksModel $task
     * @param bool $value
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processTaskSetIsActive(TasksModel $task, bool $value): \Illuminate\Http\RedirectResponse
    {
        $this->dispatchSync(new UpdateTaskJob(['is_active' => $value], $task));

        $this->dispatchSync(new StoreSystemLogJob('Tasks has been enabled with id: ' . $task->id, 201, auth()->user()));

        return redirect()->to('tasks')->with('message_success', $this->getMessage('messages.task_update'));
    }

    /**
     * Set a task record to complete.
     *
     * @param TasksModel $task
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processSetTaskToCompleted(TasksModel $task): \Illuminate\Http\RedirectResponse
    {
        $this->dispatchSync(new UpdateTaskJob(['completed' => true], $task));

        $this->dispatchSync(new StoreSystemLogJob('Tasks has been completed with id: ' . $task->id, 201, auth()->user()));

        return redirect()->back()->with('message_success', $this->getMessage('messages.task_completed'));
    }
}
