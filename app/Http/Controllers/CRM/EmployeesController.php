<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Jobs\Employee\StoreEmployeeJob;
use App\Jobs\Employee\UpdateEmployeeJob;
use App\Jobs\StoreSystemLogJob;
use App\Models\EmployeesModel;
use App\Services\ClientService;
use App\Services\EmployeesService;
use App\Services\SystemLogService;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;

class EmployeesController extends Controller
{
    use DispatchesJobs;
    private EmployeesService $employeesService;
    private SystemLogService $systemLogsService;
    private ClientService $clientService;

    public function __construct(EmployeesService $employeesService, SystemLogService $systemLogService, ClientService $clientService)
    {
        $this->middleware(SystemEnums::middleWareAuth);

        $this->employeesService = $employeesService;
        $this->systemLogsService = $systemLogService;
        $this->clientService = $clientService;
    }

    public function processRenderCreateForm()
    {
        return view('crm.employees.create')->with(['dataOfClients' => $this->clientService->loadClients()]);
    }

    public function processShowEmployeeDetails(EmployeesModel $employee)
    {
        return view('crm.employees.show')->with(['employee' => $employee]);
    }

    public function processListOfEmployees()
    {
        return view('crm.employees.index')->with([
            'employeesPaginate' => $this->employeesService->loadPaginate()
        ]);
    }

    public function processRenderUpdateForm(EmployeesModel $employee)
    {
        return view('crm.employees.edit')->with([
            'employee' => $employee,
            'clients' => $this->employeesService->loadPluckClients()
        ]);
    }

    public function processStoreEmployee(EmployeeStoreRequest $request)
    {
        $this->dispatchSync(new StoreEmployeeJob($request->validated(), auth()->user()));

        $this->dispatchSync(new StoreSystemLogJob('Employees has been added.', $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('employees')->with('message_success', $this->getMessage('messages.employee_store'));
    }

    public function processUpdateEmployee(EmployeeUpdateRequest $request, EmployeesModel $employee)
    {
        $this->dispatchSync(new UpdateEmployeeJob($request->validated(), $employee));

        return redirect()->to('employees')->with('message_success', $this->getMessage('messages.employee_update'));
    }

    public function processDeleteEmployee(EmployeesModel $employee)
    {
        if ($employee->tasks()->count() > 0) {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.task_delete_tasks'));
        }

        $employee->delete();

        $this->dispatchSync(new StoreSystemLogJob('Employees has been deleted with id: ' . $employee->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('employees')->with('message_success', $this->getMessage('messages.employee_delete'));
    }

    public function processEmployeeSetIsActive(EmployeesModel $employee, $value)
    {
        $this->dispatchSync(new UpdateEmployeeJob(['is_active' => $value], $employee));

        $this->dispatchSync(new StoreSystemLogJob('Employees has been enabled with id: ' . $employee->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('employees')->with('message_success', $this->getMessage('messages.employee_update'));
    }
}

