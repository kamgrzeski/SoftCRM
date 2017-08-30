<?php

namespace App\Http\Controllers\CRM;

use App\Client;
use App\Employees;
use App\Companies;
use App\Http\Controllers\Controller;
use App\Language;
use View;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class EmployeesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataOfEmployees = [
            'employees' => Employees::all(),
            'employeesPaginate' => Employees::paginate(10)
        ];
        return View::make('crm.employees.index')->with($dataOfEmployees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $dataOfClients = Client::pluck('full_name', 'id');
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
            if (Employees::insertRow($allInputs)) {
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
        $dataOfEmployees = Employees::find($id);
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
        $dataOfEmployees = Employees::find($id);
        $dataWithPluckOfCompanies = Companies::pluck('name', 'id');

        return View::make('crm.employees.edit')
            ->with([
                'employees' => $dataOfEmployees,
                'companies' => $dataWithPluckOfCompanies
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

        $validator = Validator::make($allInputs, Employees::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('employees')->with('message_danger', $validator);
        } else {
            if (Employees::updateRow($id, $allInputs)) {
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
     */
    public function destroy($id)
    {
        $dataOfEmployees = Employees::find($id);
        $dataOfEmployees->delete();

        return Redirect::to('employees')->with('message_success', Language::getMessage('messages.SuccessEmployeesDelete'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function enable($id)
    {
        $dataOfEmployees = Employees::find($id);

        if (Employees::setActive($dataOfEmployees->id, TRUE)) {
            return Redirect::to('employees')->with('message_success', Language::getMessage('messages.SuccessEmployeesActive'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorEmployeesActive'));
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function disable($id)
    {
        $dataOfEmployees = Employees::find($id);

        if (Employees::setActive($dataOfEmployees->id, FALSE)) {
            return Redirect::to('employees')->with('message_success', Language::getMessage('messages.EmployeesIsNowDeactivated'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.EmployeesIsDeactivated'));
        }
    }
}

