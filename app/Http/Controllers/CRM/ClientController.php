<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Jobs\Client\StoreClientJob;
use App\Jobs\Client\UpdateClientJob;
use App\Jobs\StoreSystemLogJob;
use App\Models\ClientsModel;
use App\Services\ClientService;
use App\Services\SystemLogService;
use Illuminate\Foundation\Bus\DispatchesJobs;

class ClientController extends Controller
{
    use DispatchesJobs;

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

    public function processShowClientDetails(ClientsModel $client)
    {
        return view('crm.client.show')->with(['clientDetails' => $this->clientService->loadClientDetails($client)]);
    }

    public function processRenderUpdateForm(ClientsModel $client)
    {
        return view('crm.client.edit')->with(['clientDetails' => $this->clientService->loadClientDetails($client)]);
    }

    public function processListOfClients()
    {
        return view('crm.client.index')->with([
                'clientsPaginate' => $this->clientService->loadPagination()
        ]);
    }

    public function processStoreClient(ClientStoreRequest $request)
    {
        // StoreClientJob is a job that stores the client model.
        $this->dispatchSync(new StoreClientJob($request->validated(), auth()->user()));

        // StoreSystemLogJob is a job that stores the system log.
        $this->dispatchSync(new StoreSystemLogJob('ClientsModel has been added.', $this->systemLogsService::successCode, auth()->user()));

        // Redirect to the clients page with a success message.
        return redirect()->back()->with('message_success', $this->getMessage('messages.client_store'));
    }

    public function processUpdateClient(ClientUpdateRequest $request, ClientsModel $client)
    {
        // UpdateClientJob is a job that updates the client model.
        $this->dispatchSync(new UpdateClientJob($request->validated(), $client));

        // Redirect to the clients page with a success message.
        return redirect()->back()->with('message_success', $this->getMessage('messages.client_update'));
    }

    public function processDeleteClient(ClientsModel $client)
    {
        // Check if the client has companies or employees.
        if ($client->companies()->count() > 0) {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.first_delete_companies'));
        }

        // Check if the client has employees.
        if ($client->employees()->count() > 0) {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.first_delete_employees'));
        }

        // Delete the client model.
        $client->delete();

        // Redirect to the clients page with a success message.
        return redirect()->to('clients')->with('message_success', $this->getMessage('messages.client_delete'));
    }

    public function processClientSetIsActive(ClientsModel $client, bool $value)
    {
        // UpdateClientJob is a job that updates the client model.
        $this->dispatchSync(new UpdateClientJob(['is_active' => $value], $client));

        // Redirect to the clients page with a success message.
        return redirect()->back()->with('message_success', $this->getMessage('messages.client_update'));
    }
}
