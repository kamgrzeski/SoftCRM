<?php

namespace App\Http\Controllers\CRM;

use App\Http\Requests\EmployeesStoreRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use Illuminate\Support\Facades\Redirect;

class EmployeesController extends Controller
{
    public function processListOfEmployees()
    {
        $collectDataForView = array_merge($this->collectedData(), $this->employeesService->loadDataAndPagination());

        return View::make('crm.employees.index')->with($collectDataForView);
    }

    public function showCreateForm()
    {
        $collectDataForView = array_merge($this->collectedData(), ['dataOfClients' => $this->employeesService->pluckData()]);

        return View::make('crm.employees.create')->with($collectDataForView);
    }

    public function viewEmployeeDetails($employeeId)
    {
        $collectDataForView = array_merge($this->collectedData(), ['employees' => $this->employeesService->loadEmployeeDetails($employeeId)]);

        return View::make('crm.employees.show')->with($collectDataForView);
    }

    public function showUpdateForm($employeeId)
    {
        $collectDataForView = array_merge($this->collectedData(), ['employees' =>  $this->employeesService->loadEmployeeDetails($employeeId)],
            ['clients' => $this->employeesService->loadPluckClients()], ['inputText' => $this->getMessage('messages.InputText')]);

        return View::make('crm.employees.edit')->with($collectDataForView);
    }

    public function processCreateEmployee(EmployeesStoreRequest $request)
    {
        if ($employee = $this->employeesService->execute($request->validated())) {
            $this->systemLogsService->insertSystemLogs('Employees has been add with id: '. $employee, $this->systemLogsService::successCode);
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

        $this->systemLogsService->insertSystemLogs('Employees has been deleted with id: ' . $dataOfEmployees->id, $this->systemLogsService::successCode);

        return Redirect::to('employees')->with('message_success', $this->getMessage('messages.SuccessEmployeesDelete'));
    }

    public function processSetIsActive($employeeId, $value)
    {
        if ($this->employeesService->loadIsActiveFunction($employeeId, $value)) {
            $this->systemLogsService->insertSystemLogs('Employees has been enabled with id: ' . $employeeId, $this->systemLogsService::successCode);
            return Redirect::to('employees')->with('message_success', $this->getMessage('messages.SuccessEmployeesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorEmployeesActive'));
        }
    }
}

