<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Services\ClientService;
use App\Services\SystemLogService;
use App\Traits\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use View;

class ClientController extends Controller
{
    use Language;

    private $systemLogsService;
    private $clientService;

    public function __construct()
    {
        $this->systemLogsService = new SystemLogService();
        $this->clientService = new ClientService();
    }

    public function index()
    {
        return View::make('crm.client.index')
            ->with($this->clientService->loadDataAndPagination());
    }

    public function create()
    {
        return View::make('crm.client.create')->with(
            [
                'inputText' => $this->getMessage('messages.InputText')
            ]
        );
    }

    public function show(int $clientId)
    {
        return View::make('crm.client.show')
            ->with(
                [
                    'clients' => $this->clientService->loadClientDetails($clientId)
                ]
            );
    }

    public function edit($clientId)
    {
        return View::make('crm.client.edit')
            ->with(
                [
                    'client' => $this->clientService->loadClientDetails($clientId),
                    'inputText' => $this->getMessage('messages.InputText')
                ]
            );
    }

    public function store(ClientStoreRequest $request)
    {
        if ($client = $this->clientService->execute($request->validated())) {
            $this->systemLogsService->insertSystemLogs('ClientsModel has been add with id: ' . $client, $this->systemLogsService::successCode);
            return Redirect::to('client')->with('message_success', $this->getMessage('messages.SuccessClientStore'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorClientStore'));
        }
    }

    public function update(Request $request, int $clientId)
    {
        if ($this->clientService->update($clientId, $request->all())) {
            return Redirect::to('client')->with('message_success', $this->getMessage('messages.SuccessClientUpdate'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorClientStore'));
        }
    }

    public function destroy(int $clientId)
    {
        $clientAssigned = $this->clientService->checkIfClientHaveAssignedEmployeeOrCompanie($clientId);

        if (!empty($clientAssigned)) {
            return Redirect::back()->with('message_danger', $clientAssigned);
        } else {
            $this->clientService->loadDeleteClient($clientId);
        }

        return Redirect::to('client')->with('message_success', $this->getMessage('messages.SuccessClientDelete'));
    }

    public function processSetIsActive(int $clientId, bool $value)
    {
        if ($this->clientService->processIsActive($clientId, $value)) {
            return Redirect::to('client')->with('message_success', $this->getMessage('messages.SuccessClientActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ClientIsActived'));
        }
    }
}
