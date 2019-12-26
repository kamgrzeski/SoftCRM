<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use View;

class ClientController extends Controller
{
    public function processListOfClients()
    {
        $collectDataForView = array_merge($this->collectedData(), ['clients' => $this->clientService->loadDataAndPagination()]);

        return View::make('crm.client.index')->with($collectDataForView);
    }

    public function showCreateForm()
    {
        return View::make('crm.client.create')->with($this->collectedData());
    }

    public function viewClientDetails(int $clientId)
    {
        $collectDataForView = array_merge($this->collectedData(), ['clients' => $this->clientService->loadClientDetails($clientId)]);

        return View::make('crm.client.show')->with($collectDataForView);
    }

    public function showUpdateForm(int $clientId)
    {
        $collectDataForView = array_merge($this->collectedData(), ['client' => $this->clientService->loadClientDetails($clientId)]);

        return View::make('crm.client.edit')->with($collectDataForView);
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
