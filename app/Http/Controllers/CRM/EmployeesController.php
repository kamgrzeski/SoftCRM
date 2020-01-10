<?php

namespace App\Http\Controllers\CRM;

use App\Http\Requests\EmployeesStoreRequest;
use App\Services\EmployeesService;
use App\Services\SystemLogService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use Illuminate\Support\Facades\Redirect;

class EmployeesController extends Controller
{
    private $employeesService;
    private $systemLogsService;

    public function __construct()
    {
        $this->middleware('auth');

        $this->employeesService = new EmployeesService();
        $this->systemLogsService = new SystemLogService();
    }

    public function processListOfEmployees()
    {
        return View::make('crm.employees.index')->with(
            [
                'employees' => $this->employeesService->loadEmployees(),
                'employeesPaginate' => $this->employeesService->loadPaginate()
            ]);
    }

    public function showCreateForm()
    {
        return View::make('crm.employees.create')->with(['dataOfClients' => $this->employeesService->pluckData()]);
    }

    public function viewEmployeeDetails($employeeId)
    {
        return View::make('crm.employees.show')->with(['employees' => $this->employeesService->loadEmployeeDetails($employeeId)]);
    }

    public function showUpdateForm($employeeId)
    {
        return View::make('crm.employees.edit')->with(
            [
                'employees' => $this->employeesService->loadEmployeeDetails($employeeId),
                'clients' => $this->employeesService->loadPluckClients()
            ]
        );
    }

    public function processCreateEmployee(EmployeesStoreRequest $request)
    {
        if ($employee = $this->employeesService->execute($request->validated(), $this->getAdminId())) {
            $this->systemLogsService->insertSystemLogs('Employees has been add with id: ' . $employee, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('employees')->with('message_success', $this->getMessage('messages.SuccessEmployeesStore'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorEmployeesStore'));
        }
    }

    public function processUpdateEmployee(Request $request, int $employeeId)
    {
        if ($this->employeesService->update($employeeId, $request->all())) {
            return Redirect::to('employees')->with('message_success', $this->getMessage('messages.SuccessEmployeesUpdate'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorEmployeesUpdate'));
        }
    }

    public function processDeleteEmployee($employeeId)
    {
        $dataOfEmployees = $this->employeesService->loadEmployeeDetails($employeeId);
        $countTasks = $this->employeesService->countEmployeeTasks($dataOfEmployees);

        if ($countTasks > 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.firstDeleteTasks'));
        }

        $dataOfEmployees->delete();

        $this->systemLogsService->insertSystemLogs('Employees has been deleted with id: ' . $dataOfEmployees->id, $this->systemLogsService::successCode, $this->getAdminId());

        return Redirect::to('employees')->with('message_success', $this->getMessage('messages.SuccessEmployeesDelete'));
    }

    public function processSetIsActive($employeeId, $value)
    {
        if ($this->employeesService->loadIsActiveFunction($employeeId, $value)) {
            $this->systemLogsService->insertSystemLogs('Employees has been enabled with id: ' . $employeeId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('employees')->with('message_success', $this->getMessage('messages.SuccessEmployeesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorEmployeesActive'));
        }
    }
}

