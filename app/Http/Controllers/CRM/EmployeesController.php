<?php

namespace App\Http\Controllers\CRM;

use App\Models\ClientsModel;
use App\Models\EmployeesModel;
use App\Models\Language;
use App\Services\SystemLogService;
use Request;
use App\Http\Controllers\Controller;
use View;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Config;

class EmployeesController extends Controller
{
    private $systemLogs;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
    }

    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataOfEmployees = [
            'employees' => EmployeesModel::all()->sortByDesc('created_at'),
            'employeesPaginate' => EmployeesModel::paginate(Config::get('crm_settings.pagination_size'))
        ];

        return $dataOfEmployees;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('crm.employees.index')->with($this->getDataAndPagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $dataOfClients = ClientsModel::pluck('full_name', 'id');
        return View::make('crm.employees.create', compact('dataOfClients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, Employees::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('employees/create')->with('message_danger', $validator->errors());
        } else {
            if ($employee = EmployeesModel::insertRow($allInputs)) {
                $this->systemLogs->insertSystemLogs('Employees has been add with id: '. $employee, 200);
                return Redirect::to('employees')->with('message_success', Language::getMessage('messages.SuccessEmployeesStore'));
            } else {
                return Redirect::back()->with('message_success', Language::getMessage('messages.ErrorEmployeesStore'));
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
        $dataOfEmployees = EmployeesModel::find($id);
        return View::make('crm.employees.show')
            ->with('employees', $dataOfEmployees);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $dataOfEmployees = EmployeesModel::find($id);
        $dataWithPluckOfClients = ClientsModel::pluck('full_name', 'id');

        return View::make('crm.employees.edit')
            ->with([
                'employees' => $dataOfEmployees,
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

        $validator = Validator::make($allInputs, EmployeesModel::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('employees')->with('message_danger', $validator->errors());
        } else {
            if (EmployeesModel::updateRow($id, $allInputs)) {
                return Redirect::to('employees')->with('message_success', Language::getMessage('messages.SuccessEmployeesUpdate'));
            } else {
                return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorEmployeesUpdate'));
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
        $dataOfEmployees = EmployeesModel::find($id);
        $countContacts = count($dataOfEmployees->contacts()->get());
        $countTasks = count($dataOfEmployees->tasks()->get());

        if ($countContacts > 0) {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.firstDeleteContacts'));
        }

        if ($countTasks > 0) {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.firstDeleteTasks'));
        }

        $dataOfEmployees->delete();

        $this->systemLogs->insertSystemLogs('Employees has been deleted with id: ' . $dataOfEmployees->id, 200);

        return Redirect::to('employees')->with('message_success', Language::getMessage('messages.SuccessEmployeesDelete'));
    }

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function isActiveFunction($id, $value)
    {
        $dataOfEmployees = EmployeesModel::find($id);
        if (EmployeesModel::setActive($dataOfEmployees->id, $value)) {
            $this->systemLogs->insertSystemLogs('Employees has been enabled with id: ' . $dataOfEmployees->id, 200);
            return Redirect::to('employees')->with('message_success', Language::getMessage('messages.SuccessEmployeesActive'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorEmployeesActive'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findEmployeesByValue = count(EmployeesModel::trySearchEmployeesByValue('full_name', $getValueInput, 10));
        $dataOfEmployees = $this->getDataAndPagination();

        if (!$findEmployeesByValue > 0) {
            return redirect('employees')->with('message_danger', Language::getMessage('messages.ThereIsNoEmployees'));
        } else {
            $dataOfEmployees += ['employees_search' => $findEmployeesByValue];
            Redirect::to('employees/search')->with('message_success', 'Find ' . $findEmployeesByValue . ' employees!');
        }

        return View::make('crm.employees.index')->with($dataOfEmployees);
    }
}

