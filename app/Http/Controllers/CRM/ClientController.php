<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Services\ClientService;
use App\Services\SystemLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use View;

class ClientController extends Controller
{
    private $clientService;
    private $systemLogsService;

    public function __construct()
    {
        $this->middleware('auth');

        $this->clientService = new ClientService();
        $this->systemLogsService = new SystemLogService();
    }

    public function processListOfClients()
    {
        return View::make('crm.client.index')->with(['clients' => $this->clientService->loadDataAndPagination()]);
    }

    public function showCreateForm()
    {
        return View::make('crm.client.create');
    }

    public function viewClientDetails(int $clientId)
    {
        return View::make('crm.client.show')->with(['clients' => $this->clientService->loadClientDetails($clientId)]);
    }

    public function showUpdateForm(int $clientId)
    {
        return View::make('crm.client.edit')->with(['client' => $this->clientService->loadClientDetails($clientId)]);
    }

    public function processCreateClient(ClientStoreRequest $request)
    {
        if ($client = $this->clientService->execute($request->validated())) {
            $this->systemLogsService->insertSystemLogs('ClientsModel has been add with id: ' . $client, $this->systemLogsService::successCode);
            return Redirect::to('clients')->with('message_success', $this->getMessage('messages.SuccessClientStore'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorClientStore'));
        }
    }

    public function processUpdateClient(Request $request, int $clientId)
    {
        if ($this->clientService->update($clientId, $request->all())) {
            return Redirect::to('clients')->with('message_success', $this->getMessage('messages.SuccessClientUpdate'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorClientStore'));
        }
    }

    public function processDeleteClient(int $clientId)
    {
        $clientAssigned = $this->clientService->checkIfClientHaveAssignedEmployeeOrCompanie($clientId);

        if (!empty($clientAssigned)) {
            return Redirect::back()->with('message_danger', $clientAssigned);
        } else {
            $this->clientService->loadDeleteClient($clientId);
        }

        return Redirect::to('clients')->with('message_success', $this->getMessage('messages.SuccessClientDelete'));
    }

    public function processSetIsActive(int $clientId, bool $value)
    {
        if ($this->clientService->processIsActive($clientId, $value)) {
            return Redirect::to('clients')->with('message_success', $this->getMessage('messages.SuccessClientActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ClientIsActived'));
        }
    }
}
