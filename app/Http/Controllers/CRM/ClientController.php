<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Services\ClientService;
use App\Services\SystemLogService;
use App\Traits\Language;
use Illuminate\Support\Facades\Redirect;
use Config;
use Request;
use View;

class ClientController extends Controller
{
    use Language;

    private $systemLogs;
    private $clientService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->clientService = new ClientService();
    }

    public function index()
    {
        return View::make('crm.client.index')
            ->with($this->clientService->getDataAndPagination());
    }

    public function create()
    {
        return View::make('crm.client.create')->with([
            'inputText' => $this->getMessage('messages.InputText')
        ]);
    }

    public function show($clientId)
    {
        return View::make('crm.client.show')
            ->with([
                'clients' => $this->clientService->findClient($clientId)
            ]);
    }

    public function edit($clientId)
    {
        return View::make('crm.client.edit')
            ->with([
                'client', $this->clientService->findClient($clientId),
                'inputText' => $this->getMessage('messages.InputText')
            ]);
    }

    public function store(ClientStoreRequest $request)
    {
        if ($client = $this->clientService->execute($request->validated())) {
            $this->systemLogs->insertSystemLogs('ClientsModel has been add with id: ' . $client, $this->systemLogs::successCode);
            return Redirect::to('client')->with('message_success', $this->getMessage('messages.SuccessClientStore'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorClientStore'));
        }
    }

    public function update(Request $request, int $clientId)
    {
        if ($this->clientService->update($clientId, $request->all())) {
            return Redirect::to('client')->with('message_success', $this->getMessage('messages.SuccessClientStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorClientStore'));
        }
    }

    public function destroy($clientId)
    {
        $checkForeign = $this->clientService->checkIfClientHaveForeignKey($clientId);

        if(!empty($checkForeign)) {
            return Redirect::back()->with('message_danger', $checkForeign);
        } else {
            $this->clientService->processDeleteRow($clientId);
        }

        return Redirect::to('client')->with('message_success', $this->getMessage('messages.SuccessClientDelete'));
    }

    public function search()
    {
        return true; // TODO
    }
}
