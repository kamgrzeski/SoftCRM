<?php

namespace App\Http\Controllers\CRM;

use App\Client;
use App\Contacts;
use App\Employees;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
Use Illuminate\Support\Facades\Redirect;

class ContactsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'contacts' => Contacts::all(),
            'contactsPaginate' => Contacts::paginate(10)
        ];

        return View::make('crm.contacts.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $clients = Client::pluck('full_name', 'id');
        $employees = Employees::pluck('full_name', 'id');
        return View::make('crm.contacts.create')->with(
            [
                'clients' => $clients,
                'employees' => $employees
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

        $validator = Validator::make($allInputs, Contacts::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('contacts/create')->with('message_danger', $validator->errors());
        } else {
            if (Contacts::insertRow($allInputs)) {
                return Redirect::to('contacts')->with('message_success', 'Z powodzeniem dodano spotkanie!');
            } else {
                return Redirect::back()->with('message_success', 'Błąd podczas dodawania spotkania!');
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
        $clients = Contacts::find($id);

        return View::make('crm.contacts.show')
            ->with('deals', $clients);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $clients = Contacts::find($id);

        return View::make('crm.contacts.edit')
            ->with('deals', $clients);
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

        $validator = Validator::make($allInputs, Contacts::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if (Contacts::updateRow($id, $allInputs)) {
                return Redirect::back()->with('message_success', 'Z powodzeniem zaktualizowano spotkanie!');
            } else {
                return Redirect::back()->with('message_success', 'Błąd podczas aktualizowania spotkania!');
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
        $clients = Contacts::find($id);
        $clients->delete();

        return Redirect::back()->with('message_success', 'Spotkanie zostało pomyślnie usunięte.');
    }
}
