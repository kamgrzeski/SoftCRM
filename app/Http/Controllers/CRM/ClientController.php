<?php

namespace App\Http\Controllers\CRM;

use App\Employees;
use App\Http\Controllers\Controller;
use App\Client;
use View;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\Redirect;
use App\Companies;

class ClientController extends Controller
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
            'client' => Client::all(),
            'clientPaginate' => Client::paginate(10)
        ];
        return View::make('crm.client.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('crm.client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, Client::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('client/create')->with('message_danger', $validator->errors());
        } else {
            if (Client::insertRow($allInputs)) {
                return Redirect::to('client')->with('message_success', 'Z powodzeniem dodano klienta!');
            } else {
                return Redirect::back()->with('message_success', 'Błąd podczas dodawania klienta!');
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
        $clients = Client::find($id);
        $companies = Companies::with('client')->get();
        $employees = Employees::with('companies')->get();

        return View::make('crm.client.show')
            ->with([
                'clients' => $clients,
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
        $clients = Client::find($id);

        return View::make('crm.client.edit')
            ->with('client', $clients);
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

        $validator = Validator::make($allInputs, Client::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if (Client::updateRow($id, $allInputs)) {
                return Redirect::back()->with('message_success', 'Z powodzeniem zaktualizowano klienta!');
            } else {
                return Redirect::back()->with('message_success', 'Błąd podczas aktualizowania klienta!');
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
        $clients = Client::find($id);
        $clients->delete();

        return Redirect::to('client')->with('message_success', 'Klient została pomyślnie usunięta.');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function enable($id)
    {
        $clients = Client::find($id);

        if (Client::setActive($clients->id, TRUE)) {
            return Redirect::back()->with('message_success', 'Klient od teraz jest aktywny.');
        } else {
            return Redirect::back()->with('message_danger', 'Klient jest już aktywny.');
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function disable($id)
    {
        $clients = Client::find($id);

        if (Client::setActive($clients->id, FALSE)) {
            return Redirect::back()->with('message_success', 'Klient został deaktywowany.');
        } else {
            return Redirect::back()->with('message_danger', 'Klient jest juz nieaktywny.');
        }
    }
}
