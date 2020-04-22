<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
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

    public function processRenderCreateForm()
    {
        return View::make('crm.client.create');
    }

    public function processShowClientDetails(int $clientId)
    {
        return View::make('crm.client.show')->with(['clientDetails' => $this->clientService->loadClientDetails($clientId)]);
    }

    public function processRenderUpdateForm(int $clientId)
    {
        return View::make('crm.client.edit')->with(['clientDetails' => $this->clientService->loadClientDetails($clientId)]);
    }

    public function processListOfClients()
    {
        return View::make('crm.client.index')->with(
            [
                'clients' => $this->clientService->loadClients(),
                'clientsPaginate' => $this->clientService->loadPagination()
            ]
        );
    }

    public function processStoreClient(ClientStoreRequest $request)
    {
        $storedClientId = $this->clientService->execute($request->validated(), $this->getAdminId());

        if ($storedClientId) {
            $this->systemLogsService->loadInsertSystemLogs('ClientsModel has been add with id: ' . $storedClientId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('clients')->with('message_success', $this->getMessage('messages.SuccessClientStore'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorClientStore'));
        }
    }

    public function processUpdateClient(ClientUpdateRequest $request, int $clientId)
    {
        if ($this->clientService->update($clientId, $request->validated())) {
            return Redirect::to('clients')->with('message_success', $this->getMessage('messages.SuccessClientUpdate'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorClientStore'));
        }
    }

    public function processDeleteClient(int $clientId)
    {
        $clientAssigned = $this->clientService->checkIfClientHaveAssignedEmployeeOrCompany($clientId);

        if (!empty($clientAssigned)) {
            return Redirect::back()->with('message_danger', $clientAssigned);
        } else {
            $this->clientService->loadDeleteClient($clientId);
        }

        return Redirect::to('clients')->with('message_success', $this->getMessage('messages.SuccessClientDelete'));
    }

    public function processClientSetIsActive(int $clientId, bool $value)
    {
        if ($this->clientService->loadSetActive($clientId, $value)) {
            return Redirect::to('clients')->with('message_success', $this->getMessage('messages.SuccessClientActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ClientIsActived'));
        }
    }
}
