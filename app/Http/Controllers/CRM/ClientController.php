<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Jobs\Client\StoreClientJob;
use App\Jobs\Client\UpdateClientJob;
use App\Jobs\StoreSystemLogJob;
use App\Models\ClientsModel;
use App\Queries\ClientsQueries;
use App\Services\ClientService;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class ClientController
 *
 * Controller for handling client-related operations in the CRM.
 */
class ClientController extends Controller
{
    use DispatchesJobs;

    private ClientService $clientService;
    /**
     * ClientController constructor.
     *
     * @param ClientService $clientService
     */
    public function __construct(ClientService $clientService)
    {
        $this->middleware(self::MIDDLEWARE_AUTH);

        $this->clientService = $clientService;
    }

    /**
     * Render the form for creating a new client record.
     *
     * @return \Illuminate\View\View
     */
    public function processRenderCreateForm(): \Illuminate\View\View
    {
        // Return the view for creating a new client record.
        return view('crm.clients.create');
    }

    /**
     * Show the details of a specific client record.
     *
     * @param ClientsModel $client
     * @return \Illuminate\View\View
     */
    public function processShowClientDetails(ClientsModel $client): \Illuminate\View\View
    {
        // Return the view with the client details.
        return view('crm.clients.show')->with(['client' => $this->clientService->loadClientDetails($client)]);
    }

    /**
     * Render the form for updating an existing client record.
     *
     * @param ClientsModel $client
     * @return \Illuminate\View\View
     */
    public function processRenderUpdateForm(ClientsModel $client): \Illuminate\View\View
    {
        // Return the view for updating the client record.
        return view('crm.clients.edit')->with(['client' => $this->clientService->loadClientDetails($client)]);
    }

    /**
     * List all client records with pagination.
     *
     * @return \Illuminate\View\View
     */
    public function processListOfClients(): \Illuminate\View\View
    {
        // Return the view with the paginated list of clients.
        return view('crm.clients.index')->with([
            'clients' => ClientsQueries::getPaginate()
        ]);
    }

    /**
     * Store a new client record.
     *
     * @param ClientStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processStoreClient(ClientStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        // StoreClientJob is a job that stores the client model.
        $this->dispatchSync(new StoreClientJob($request->validated(), auth()->user()));

        // StoreSystemLogJob is a job that stores the system log.
        $this->dispatchSync(new StoreSystemLogJob('ClientsModel has been added.', 201, auth()->user()));

        // Redirect to the clients page with a success message.
        return redirect()->to('clients')->with('message_success', $this->getMessage('messages.client_store'));
    }

    /**
     * Update an existing client record.
     *
     * @param ClientUpdateRequest $request
     * @param ClientsModel $client
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processUpdateClient(ClientUpdateRequest $request, ClientsModel $client)
    {
        // UpdateClientJob is a job that updates the client model.
        $this->dispatchSync(new UpdateClientJob($request->validated(), $client));

        // Redirect to the clients page with a success message.
        return redirect()->back()->with('message_success', $this->getMessage('messages.client_update'));
    }

    /**
     * Delete a client record.
     *
     * @param ClientsModel $client
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processDeleteClient(ClientsModel $client): \Illuminate\Http\RedirectResponse
    {
        // Delete the client model.
        $client->delete();

        // Redirect to the clients page with a success message.
        return redirect()->to('clients')->with('message_success', $this->getMessage('messages.client_delete'));
    }

    /**
     * Set the active status of a client record.
     *
     * @param ClientsModel $client
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processClientSetIsActive(ClientsModel $client): \Illuminate\Http\RedirectResponse
    {
        // UpdateClientJob is a job that updates the client model.
        $this->dispatchSync(new UpdateClientJob(['is_active' => ! $client->is_active], $client));

        // Redirect to the clients page with a success message.
        return redirect()->back()->with('message_success', $this->getMessage('messages.client_update'));
    }
}
