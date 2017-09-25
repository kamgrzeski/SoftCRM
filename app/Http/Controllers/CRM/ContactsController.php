<?php

namespace App\Http\Controllers\CRM;

use App\Client;
use App\Contacts;
use App\Employees;
use App\Http\Controllers\Controller;
use App\Language;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class ContactsController extends Controller
{
    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataOfContacts = [
            'contacts' => Contacts::all(),
            'contactsPaginate' => Contacts::paginate(Config::get('crm_settings.pagination_size'))
        ];

        return $dataOfContacts;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('crm.contacts.index')->with($this->getDataAndPagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $dataOfClients = Client::pluck('full_name', 'id');
        $dataOfEmployees = Employees::pluck('full_name', 'id');
        return View::make('crm.contacts.create')->with(
            [
                'clients' => $dataOfClients,
                'employees' => $dataOfEmployees
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
                return Redirect::to('contacts')->with('message_success', Language::getMessage('messages.SuccessContactsStore'));
            } else {
                return Redirect::back()->with('message_success', Language::getMessage('messages.ErrorContactsStore'));
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
        $dataOfContacts = Contacts::find($id);

        return View::make('crm.contacts.show')
            ->with('contacts', $dataOfContacts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $dataOfContacts = Contacts::find($id);
        $dataWithPluckOfClients = Client::pluck('full_name', 'id');
        $dataWithPluckOfEmployees = Employees::pluck('full_name', 'id');

        return View::make('crm.contacts.edit')
            ->with([
                'contacts' => $dataOfContacts,
                'clients' => $dataWithPluckOfClients,
                'employees' => $dataWithPluckOfEmployees
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

        $validator = Validator::make($allInputs, Contacts::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if (Contacts::updateRow($id, $allInputs)) {
                return Redirect::to('contacts')->with('message_success', Language::getMessage('messages.SuccessContactsUpdate'));
            } else {
                return Redirect::back()->with('message_success', Language::getMessage('messages.ErrorContactsUpdate'));
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
        $dataOfContacts = Contacts::find($id);
        $dataOfContacts->delete();

        return Redirect::to('contacts')->with('message_success', Language::getMessage('messages.SuccessContactsDelete'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findDealsByValue = count(Contacts::trySearchContactsByValue('full_name', $getValueInput, 10));
        $dataOfContacts = $this->getDataAndPagination();

        if (!$findDealsByValue > 0) {
            return redirect('contacts')->with('message_danger', Language::getMessage('messages.ThereIsNoDeals'));
        } else {
            $dataOfContacts += ['contacts_search' => $findDealsByValue];
            Redirect::to('contacts/search')->with('message_success', 'Find ' . $findDealsByValue . ' contacts!');
        }

        return View::make('crm.contacts.index')->with($dataOfContacts);
    }
}
