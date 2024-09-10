<?php

namespace App\Http\Controllers\CRM;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Jobs\Employee\StoreEmployeeJob;
use App\Jobs\Employee\UpdateEmployeeJob;
use App\Jobs\StoreSystemLogJob;
use App\Models\EmployeesModel;
use App\Queries\ClientsQueries;
use App\Services\ClientService;
use App\Services\EmployeesService;
use App\Services\SystemLogService;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class EmployeesController
 *
 * Controller for handling employee-related operations in the CRM.
 */
class EmployeesController extends Controller
{
    use DispatchesJobs;
    private EmployeesService $employeesService;
    private SystemLogService $systemLogsService;
    private ClientService $clientService;

    /**
     * EmployeesController constructor.
     *
     * @param EmployeesService $employeesService
     * @param SystemLogService $systemLogService
     * @param ClientService $clientService
     */
    public function __construct(EmployeesService $employeesService, SystemLogService $systemLogService, ClientService $clientService)
    {
        $this->middleware(self::MIDDLEWARE_AUTH);

        $this->employeesService = $employeesService;
        $this->systemLogsService = $systemLogService;
        $this->clientService = $clientService;
    }

    /**
     * Render the form for creating a new employee record.
     *
     * @return \Illuminate\View\View
     */
    public function processRenderCreateForm()
    {
        return view('crm.employees.create')->with(['clients' => ClientsQueries::getAll()]);
    }

    /**
     * Show the details of a specific employee record.
     *
     * @param EmployeesModel $employee
     * @return \Illuminate\View\View
     */
    public function processShowEmployeeDetails(EmployeesModel $employee)
    {
        return view('crm.employees.show')->with(['employee' => $employee]);
    }

    /**
     * List all employee records with pagination.
     *
     * @return \Illuminate\View\View
     */
    public function processListOfEmployees()
    {
        return view('crm.employees.index')->with([
            'employeesPaginate' => $this->employeesService->loadPaginate()
        ]);
    }

    /**
     * Render the form for updating an existing employee record.
     *
     * @param EmployeesModel $employee
     * @return \Illuminate\View\View
     */
    public function processRenderUpdateForm(EmployeesModel $employee)
    {
        return view('crm.employees.edit')->with([
            'employee' => $employee,
            'clients' => ClientsQueries::getAll()
        ]);
    }

    /**
     * Store a new employee record.
     *
     * @param EmployeeStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processStoreEmployee(EmployeeStoreRequest $request)
    {
        $this->dispatchSync(new StoreEmployeeJob($request->validated(), auth()->user()));

        $this->dispatchSync(new StoreSystemLogJob('Employees has been added.', $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('employees')->with('message_success', $this->getMessage('messages.employee_store'));
    }

    /**
     * Update an existing employee record.
     *
     * @param EmployeeUpdateRequest $request
     * @param EmployeesModel $employee
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processUpdateEmployee(EmployeeUpdateRequest $request, EmployeesModel $employee)
    {
        $this->dispatchSync(new UpdateEmployeeJob($request->validated(), $employee));

        return redirect()->to('employees')->with('message_success', $this->getMessage('messages.employee_update'));
    }

    /**
     * Delete an employee record.
     *
     * @param EmployeesModel $employee
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processDeleteEmployee(EmployeesModel $employee)
    {
        if ($employee->tasks()->count() > 0) {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.task_delete_tasks'));
        }

        $employee->delete();

        $this->dispatchSync(new StoreSystemLogJob('Employees has been deleted with id: ' . $employee->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('employees')->with('message_success', $this->getMessage('messages.employee_delete'));
    }

    /**
     * Set the active status of an employee record.
     *
     * @param EmployeesModel $employee
     * @param bool $value
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processEmployeeSetIsActive(EmployeesModel $employee, $value)
    {
        $this->dispatchSync(new UpdateEmployeeJob(['is_active' => $value], $employee));

        $this->dispatchSync(new StoreSystemLogJob('Employees has been enabled with id: ' . $employee->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('employees')->with('message_success', $this->getMessage('messages.employee_update'));
    }
}
