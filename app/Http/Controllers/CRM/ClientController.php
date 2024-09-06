<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Services\ClientService;
use App\Services\SystemLogService;
use Illuminate\Support\Facades\Redirect;

class ClientController extends Controller
{
    private ClientService $clientService;
    private SystemLogService $systemLogsService;

    public function __construct(ClientService $clientService, SystemLogService $systemLogService)
    {
        $this->middleware(SystemEnums::middleWareAuth);

        $this->clientService = $clientService;
        $this->systemLogsService = $systemLogService;
    }

    public function processRenderCreateForm()
    {
        return view('crm.client.create');
    }

    public function processShowClientDetails(int $clientId)
    {
        return view('crm.client.show')->with(['clientDetails' => $this->clientService->loadClientDetails($clientId)]);
    }

    public function processRenderUpdateForm(int $clientId)
    {
        return view('crm.client.edit')->with(['clientDetails' => $this->clientService->loadClientDetails($clientId)]);
    }

    public function processListOfClients()
    {
        return view('crm.client.index')->with(
            [
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
            $msg = $value ? 'ClientIsNowDeactivated' : 'SuccessClientActive';
            return Redirect::to('clients')->with('message_success', $this->getMessage('messages.' . $msg));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorSettingsUpdate'));
        }
    }
}
