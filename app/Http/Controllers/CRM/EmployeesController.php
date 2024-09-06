<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Jobs\StoreSystemLogJob;
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
        return view('crm.employees.create')->with(['dataOfClients' => $this->clientService->loadClients(true)]);
    }

    public function processShowEmployeeDetails($employeeId)
    {
        return view('crm.employees.show')->with(['employee' => $this->employeesService->loadEmployeeDetails($employeeId)]);
    }

    public function processListOfEmployees()
    {
        return view('crm.employees.index')->with(
            [
                'employeesPaginate' => $this->employeesService->loadPaginate()
            ]);
    }

    public function processRenderUpdateForm($employeeId)
    {
        return view('crm.employees.edit')->with(
            [
                'employee' => $this->employeesService->loadEmployeeDetails($employeeId),
                'clients' => $this->employeesService->loadPluckClients()
            ]
        );
    }

    public function processStoreEmployee(EmployeeStoreRequest $request)
    {
        $storedEmployeeId = $this->employeesService->execute($request->validated(), $this->getAdminId());

        if ($storedEmployeeId) {
            $this->dispatchSync(new StoreSystemLogJob('Employees has been add with id: ' . $storedEmployeeId, $this->systemLogsService::successCode, auth()->user()));
            return redirect()->to('employees')->with('message_success', $this->getMessage('messages.SuccessEmployeesStore'));
        } else {
            return redirect()->back()->with('message_success', $this->getMessage('messages.ErrorEmployeesStore'));
        }
    }

    public function processUpdateEmployee(EmployeeUpdateRequest $request, int $employeeId)
    {
        if ($this->employeesService->update($employeeId, $request->validated())) {
            return redirect()->to('employees')->with('message_success', $this->getMessage('messages.SuccessEmployeesUpdate'));
        } else {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.ErrorEmployeesUpdate'));
        }
    }

    public function processDeleteEmployee($employeeId)
    {
        $dataOfEmployees = $this->employeesService->loadEmployeeDetails($employeeId);
        $countTasks = $this->employeesService->countEmployeeTasks($dataOfEmployees);

        if ($countTasks > 0) {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.firstDeleteTasks'));
        }

        $dataOfEmployees->delete();

        $this->dispatchSync(new StoreSystemLogJob('Employees has been deleted with id: ' . $dataOfEmployees->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('employees')->with('message_success', $this->getMessage('messages.SuccessEmployeesDelete'));
    }

    public function processEmployeeSetIsActive($employeeId, $value)
    {
        if ($this->employeesService->loadSetActive($employeeId, $value)) {
            $this->dispatchSync(new StoreSystemLogJob('Employees has been enabled with id: ' . $employeeId, $this->systemLogsService::successCode, auth()->user()));

            $msg = $value ? 'SuccessEmployeesActive' : 'EmployeesIsNowDeactivated';

            return redirect()->to('employees')->with('message_success', $this->getMessage('messages.' . $msg));
        } else {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.ErrorEmployeesActive'));
        }
    }
}

