<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactsStoreRequest;
use App\Models\ContactsModel;
use App\Services\ContactsService;
use App\Services\SystemLogService;
use App\Traits\Language;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class ContactsController extends Controller
{
    use Language;

    private $systemLogs;
    private $contactsModel;
    private $contactsService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->contactsModel = new ContactsModel();
        $this->contactsService = new ContactsService();
    }

    private function getDataAndPagination()
    {
        $dataOfContacts = [
            'contacts' => $this->contactsService->getContacts(),
            'contactsPaginate' => $this->contactsService->getPaginate()
        ];

        return $dataOfContacts;
    }

    public function index()
    {
        return View::make('crm.contacts.index')->with($this->getDataAndPagination());
    }

    public function create()
    {
        $dataForView = $this->contactsService->collectDataForView();

        return View::make('crm.contacts.create')->with(
            [
                'clients' => $dataForView->dataOfClients,
                'employees' => $dataForView->ataOfEmployees,
                'inputText' => $this->getMessage('messages.InputText')
            ]);
    }

    public function store(ContactsStoreRequest $request)
    {
        if ($contact = $this->contactsService->execute($request->validated())) {
            $this->systemLogs->insertSystemLogs('Contact has been add with id: '. $contact, $this->systemLogs::successCode);
            return Redirect::to('contacts')->with('message_success', $this->getMessage('messages.SuccessContactsStore'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorContactsStore'));
        }
    }

    public function show($contactId)
    {
        return View::make('crm.contacts.show')
            ->with('contacts', $this->contactsService->getContact($contactId));
    }

    public function edit($contactId)
    {
        $dataOfContacts = $this->contactsService->getContact($contactId);
        $dataForView = $this->contactsService->collectDataForView();

        return View::make('crm.contacts.edit')
            ->with([
                'contacts' => $dataOfContacts,
                'clients' => $dataForView->dataWithPluckOfClients,
                'employees' => $dataForView->dataWithPluckOfEmployees
            ]);
    }

    public function update(Request $request, int $contactId)
    {
        if ($this->contactsModel->updateRow($contactId, $request->all())) {
            return Redirect::to('contacts')->with('message_success', $this->getMessage('messages.SuccessContactsUpdate'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorContactsUpdate'));
        }
    }

    public function destroy($contactId)
    {
        $dataOfContacts = $this->contactsService->getContact($contactId);
        $dataOfContacts->delete();

        $this->systemLogs->insertSystemLogs('ContactsModel has been deleted with id: ' . $dataOfContacts->id, $this->systemLogs::successCode);

        return Redirect::to('contacts')->with('message_success', $this->getMessage('messages.SuccessContactsDelete'));
    }

    public function search()
    {
        return true; // TODO
    }
}
