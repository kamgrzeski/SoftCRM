<?php

namespace App\Http\Controllers\CRM;

use App\Client;
use App\Employees;
use App\Companies;
use App\Http\Controllers\Controller;
use View;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class EmployeesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
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
        $data = [
            'employees' => Employees::all(),
            'employeesPaginate' => Employees::paginate(10)
        ];
        return View::make('crm.employees.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $clients = Client::pluck('full_name', 'id');
        return View::make('crm.employees.create', compact('clients'));
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
                return Redirect::to('employees')->with('message_success', 'Z powodzeniem dodano firmę!');
            } else {
                return Redirect::back()->with('message_success', 'Błąd podczas dodawania firmy!');
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
        $employees = Employees::find($id);
        return View::make('crm.employees.show')
            ->with('employees', $employees);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $employees = Employees::find($id);
        $companies = Companies::pluck('name', 'id');

        return View::make('crm.employees.edit')
            ->with([
                'employees' => $employees,
                'companies' => $companies
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
                return Redirect::to('employees')->with('message_success', 'Z powodzeniem zaktualizowano pracownika!');
            } else {
                return Redirect::back()->with('message_danger', 'Błąd podczas aktualizowania pracownika!');
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
        $employees = Employees::find($id);
        $employees->delete();

        return Redirect::to('employees')->with('message_success', 'Pracownik został pomyślnie usunięty.');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function enable($id)
    {
        $employees = Employees::find($id);

        if (Employees::setActive($employees->id, TRUE)) {
            return Redirect::to('employees')->with('message_success', 'Pracownik od teraz jest aktywny.');
        } else {
            return Redirect::back()->with('message_danger', 'Pracownik jest już aktywny.');
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function disable($id)
    {
        $employees = Employees::find($id);

        if (Employees::setActive($employees->id, FALSE)) {
            return Redirect::to('employees')->with('message_success', 'Pracownik została deaktywowany.');
        } else {
            return Redirect::back()->with('message_danger', 'Pracownik jest juz nieaktywny.');
        }
    }
}

