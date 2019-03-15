<?php

namespace App\Http\Controllers\CRM;

use App\Http\Requests\EmployeesStoreRequest;
use App\Models\ClientsModel;
use App\Services\EmployeesService;
use App\Services\SystemLogService;
use App\Traits\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use Illuminate\Support\Facades\Redirect;
use Config;

class EmployeesController extends Controller
{
    use Language;

    private $systemLogs;
    private $employeesService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->employeesService = new EmployeesService();
    }

    public function index()
    {
        return View::make('crm.employees.index')->with($this->employeesService->getDataAndPagination());
    }

    public function create()
    {
        return View::make('crm.employees.create')->with([
            'dataOfClients' => $this->employeesService->pluckData(),
            'inputText' => $this->getMessage('messages.InputText')
        ]);
    }

    public function show($employeeId)
    {
        return View::make('crm.employees.show')
            ->with('employees', $this->employeesService->loadEmployeeDetails($employeeId));
    }

    public function edit($employeeId)
    {
        $dataWithPluckOfClients = ClientsModel::pluck('full_name', 'id');

        return View::make('crm.employees.edit')
            ->with([
                'employees' =>  $this->employeesService->loadEmployeeDetails($employeeId),
                'clients' => $dataWithPluckOfClients
            ]);
    }

    public function store(EmployeesStoreRequest $request)
    {
        if ($employee = $this->employeesService->execute($request->validated())) {
            $this->systemLogs->insertSystemLogs('Employees has been add with id: '. $employee, $this->systemLogs::successCode);
            return Redirect::to('employees')->with('message_success', $this->getMessage('messages.SuccessEmployeesStore'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorEmployeesStore'));
        }
    }

    public function update(Request $request, int $employeeId)
    {
        if ($this->employeesService->update($employeeId, $request->all())) {
            return Redirect::to('employees')->with('message_success', $this->getMessage('messages.SuccessEmployeesUpdate'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorEmployeesUpdate'));
        }
    }

    public function destroy($employeeId)
    {
        $dataOfEmployees = $this->employeesService->loadEmployeeDetails($employeeId);
        $countContacts = $this->employeesService->countEmployeeContacts($dataOfEmployees);
        $countTasks = $this->employeesService->countEmployeeTasks($dataOfEmployees);

        if ($countContacts > 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.firstDeleteContacts'));
        }

        if ($countTasks > 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.firstDeleteTasks'));
        }

        $dataOfEmployees->delete();

        $this->systemLogs->insertSystemLogs('Employees has been deleted with id: ' . $dataOfEmployees->id, $this->systemLogs::successCode);

        return Redirect::to('employees')->with('message_success', $this->getMessage('messages.SuccessEmployeesDelete'));
    }

    public function isActiveFunction($employeeId, $value)
    {
        if ($this->employeesService->loadIsActiveFunction($employeeId, $value)) {
            $this->systemLogs->insertSystemLogs('Employees has been enabled with id: ' . $employeeId, $this->systemLogs::successCode);
            return Redirect::to('employees')->with('message_success', $this->getMessage('messages.SuccessEmployeesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorEmployeesActive'));
        }
    }

    public function search()
    {
        return true; // TODO
    }
}

