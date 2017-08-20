<?php

namespace App\Http\Controllers\CRM;

use App\Companies;
use App\Employees;
use App\Http\Controllers\Controller;
use View;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Client;

class CompaniesController extends Controller
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
            'companies' => Companies::all(),
            'companiesPaginate' => Companies::paginate(10)
        ];
        return View::make('crm.companies.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $clients = Client::pluck('full_name', 'id');
        return View::make('crm.companies.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, Companies::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('companies/create')->with('message_danger', $validator->errors());
        } else {
            if (Companies::insertRow($allInputs)) {
                return Redirect::to('companies')->with('message_success', 'Z powodzeniem dodano firmę!');
            } else {
                return Redirect::back()->with('message_danger', 'Błąd podczas dodawania firmy!');
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
        $companies = Companies::find($id);
        $employees = Employees::with('companies')->get();

        return View::make('crm.companies.show')
            ->with([
                'companies' => $companies,
                'employees' => $employees
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $companies = Companies::find($id);

        return View::make('crm.companies.edit')
            ->with('companies', $companies);
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

        $validator = Validator::make($allInputs, Companies::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('companies')->with('message_danger', $validator);
        } else {
            if (Companies::updateRow($id, $allInputs)) {
                return Redirect::to('companies')->with('message_success', 'Z powodzeniem zaktualizowano firmę!');
            } else {
                return Redirect::back()->with('message_success', 'Błąd podczas aktualizowania firmy!');
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
        $companies = Companies::find($id);
        $companies->delete();

        return Redirect::to('companies')->with('message_success', 'Firma została pomyślnie usunięta.');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function enable($id)
    {
        $companies = Companies::find($id);

        if (Companies::setActive($companies->id, TRUE)) {
            return Redirect::to('companies')->with('message_success', 'Firma od teraz jest aktywna.');
        } else {
            return Redirect::back()->with('message_danger', 'Firma jest już aktywna.');
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function disable($id)
    {
        $companies = Companies::find($id);

        if (Companies::setActive($companies->id, FALSE)) {
            return Redirect::to('companies')->with('message_success', 'Firma została deaktywowana.');
        } else {
            return Redirect::back()->with('message_danger', 'Firma jest juz nieaktywna.');
        }
    }
}
