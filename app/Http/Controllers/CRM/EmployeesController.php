<?php

namespace App\Http\Controllers\CRM;

use App\Models\ClientsModel;
use App\Models\EmployeesModel;
use App\Services\EmployeesService;
use App\Services\SystemLogService;
use App\Traits\Language;
use Request;
use App\Http\Controllers\Controller;
use View;
use Validator;
use Illuminate\Support\Facades\Input;
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('crm.employees.index')->with($this->employeesService->getDataAndPagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('crm.employees.create')->with([
            'dataOfClients' => $this->employeesService->pluckData(),
            'inputText' => $this->getMessage('messages.InputText')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, $this->employeesService->loadRules());

        if ($validator->fails()) {
            return Redirect::to('employees/create')->with('message_danger', $validator->errors());
        } else {
            if ($employee = $this->employeesService->execute($allInputs)) {
                $this->systemLogs->insertSystemLogs('Employees has been add with id: '. $employee, $this->systemLogs::successCode);
                return Redirect::to('employees')->with('message_success', $this->getMessage('messages.SuccessEmployeesStore'));
            } else {
                return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorEmployeesStore'));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        return View::make('crm.employees.show')
            ->with('employees', $this->employeesService->loadEmployeeDetails($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $dataWithPluckOfClients = ClientsModel::pluck('full_name', 'id');

        return View::make('crm.employees.edit')
            ->with([
                'employees' =>  $this->employeesService->loadEmployeeDetails($id),
                'clients' => $dataWithPluckOfClients
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, $this->employeesService->loadRules());

        if ($validator->fails()) {
            return Redirect::to('employees')->with('message_danger', $validator->errors());
        } else {
            if ($this->employeesService->update($id, $allInputs)) {
                return Redirect::to('employees')->with('message_success', $this->getMessage('messages.SuccessEmployeesUpdate'));
            } else {
                return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorEmployeesUpdate'));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $dataOfEmployees = $this->employeesService->loadEmployeeDetails($id);
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

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function isActiveFunction($id, $value)
    {
        $dataOfEmployees = EmployeesModel::find($id);
        if ($this->employeesService->loadIsActiveFunction($dataOfEmployees->id, $value)) {
            $this->systemLogs->insertSystemLogs('Employees has been enabled with id: ' . $dataOfEmployees->id, $this->systemLogs::successCode);
            return Redirect::to('employees')->with('message_success', $this->getMessage('messages.SuccessEmployeesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorEmployeesActive'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findEmployeesByValue = $this->employeesService->loadSearch($getValueInput);
        $dataOfEmployees = $this->employeesService->getDataAndPagination();

        if (!$findEmployeesByValue > 0) {
            return redirect('employees')->with('message_danger', $this->getMessage('messages.ThereIsNoEmployees'));
        } else {
            $dataOfEmployees += ['employees_search' => $findEmployeesByValue];
            Redirect::to('employees/search')->with('message_success', 'Find ' . $findEmployeesByValue . ' employees!');
        }

        return View::make('crm.employees.index')->with($dataOfEmployees);
    }
}

