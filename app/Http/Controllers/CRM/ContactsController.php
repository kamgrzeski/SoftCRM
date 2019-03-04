<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\ClientsModel;
use App\Models\ContactsModel;
use App\Models\EmployeesModel;
use App\Models\Language;
use App\Services\ContactsService;
use App\Services\SystemLogService;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class ContactsController extends Controller
{
    private $systemLogs;
    private $language;
    private $contactsModel;
    private $contactsService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->language = new Language();
        $this->contactsModel = new ContactsModel();
        $this->contactsService = new ContactsService();
    }

    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataOfContacts = [
            'contacts' => ContactsModel::all()->sortByDesc('created_at'),
            'contactsPaginate' => ContactsModel::paginate(Config::get('crm_settings.pagination_size'))
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
        $dataOfClients = ClientsModel::pluck('full_name', 'id');
        $dataOfEmployees = EmployeesModel::pluck('full_name', 'id');
        return View::make('crm.contacts.create')->with(
            [
                'clients' => $dataOfClients,
                'employees' => $dataOfEmployees,
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

        $validator = Validator::make($allInputs, $this->contactsModel->getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('contacts/create')->with('message_danger', $validator->errors());
        } else {
            if ($contact = $this->contactsModel->insertRow($allInputs)) {
                $this->systemLogs->insertSystemLogs('Contact has been add with id: '. $contact, $this->systemLogs::successCode);
                return Redirect::to('contacts')->with('message_success', $this->getMessage('messages.SuccessContactsStore'));
            } else {
                return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorContactsStore'));
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
        $dataOfContacts = ContactsModel::find($id);

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
        $dataOfContacts = ContactsModel::find($id);
        $dataWithPluckOfClients = ClientsModel::pluck('full_name', 'id');
        $dataWithPluckOfEmployees = EmployeesModel::pluck('full_name', 'id');

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

        $validator = Validator::make($allInputs, $this->contactsModel->getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if ($this->contactsModel->updateRow($id, $allInputs)) {
                return Redirect::to('contacts')->with('message_success', $this->getMessage('messages.SuccessContactsUpdate'));
            } else {
                return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorContactsUpdate'));
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
        $dataOfContacts = ContactsModel::find($id);
        $dataOfContacts->delete();

        $this->systemLogs->insertSystemLogs('ContactsModel has been deleted with id: ' . $dataOfContacts->id, $this->systemLogs::successCode);

        return Redirect::to('contacts')->with('message_success', $this->getMessage('messages.SuccessContactsDelete'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findDealsByValue = count(ContactsModel::trySearchContactsByValue('full_name', $getValueInput, 10));
        $dataOfContacts = $this->getDataAndPagination();

        if (!$findDealsByValue > 0) {
            return redirect('contacts')->with('message_danger', $this->getMessage('messages.ThereIsNoDeals'));
        } else {
            $dataOfContacts += ['contacts_search' => $findDealsByValue];
            Redirect::to('contacts/search')->with('message_success', 'Find ' . $findDealsByValue . ' contacts!');
        }

        return View::make('crm.contacts.index')->with($dataOfContacts);
    }
}
