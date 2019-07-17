<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientsUpdateRequest;
use App\Services\ClientsService;
use Illuminate\Http\Request;
use Illuminate\Http\{JsonResponse};

class ClientsController extends Controller
{
    private $clientsService;

    public function __construct()
    {
        parent::__construct();

        $this->clientsService = new ClientsService();
    }

    public function processListOfClients() : JsonResponse
    {
        if ($clientsList = $this->clientsService->loadClientsList()) {
            return $this->jsonResponse('Clients list.', $clientsList, $this->successCode, $this->startTime);
        } else {
            return $this->jsonResponse('Something went wrong while collection client list.', [], $this->unauthorized, $this->startTime);
        }
    }

    public function processCreateClient(ClientStoreRequest $request) : JsonResponse
    {
        $validatedData = $this->convertToObject($request->validated());

        if ($clientId = $this->clientsService->execute($validatedData)) {
            $this->insertSystemLogs('Client has been stored. Client ID: ' . $clientId, $this->successCode);
            return $this->jsonResponse('You have successfully stored client!', [], $this->successCode, $this->startTime);
        } else {
            return $this->jsonResponse('Something went wrong while storing client.', [], $this->unauthorized, $this->startTime);
        }
    }

    public function processClientDetails(Request $request) : JsonResponse
    {
        if ($clientDetails = $this->clientsService->loadClientDetails($request->route('clientId'))) {
            return $this->jsonResponse('Client details', $clientDetails, $this->successCode, $this->startTime);
        } else {
            return $this->jsonResponse('Something went wrong while collecting client data.', [], $this->unauthorized, $this->startTime);
        }
    }

    public function processDeleteClient(Request $request) : JsonResponse
    {
        $clientId = $request->route('clientId');

        if($this->clientsService->checkIfClientHaveAssignedCompanies($clientId)) {
            return $this->jsonResponse('Client have assigned companies. You cant delete this client.', [], $this->preconditionFailed, $this->startTime);
        }

        if($this->clientsService->checkIfClientHaveAssignedEmployees($clientId)) {
            return $this->jsonResponse('Client have assigned employees. You cant delete this employees.', [], $this->preconditionFailed, $this->startTime);
        }

        if ($this->clientsService->loadClientDelete($clientId)) {
            return $this->jsonResponse('Client has been deleted.', ['clientId' => $clientId], $this->successCode, $this->startTime);
        } else {
            return $this->jsonResponse('Something went wrong while collecting client data.', [], $this->unauthorized, $this->startTime);
        }
    }

    public function processUpdateClient(ClientsUpdateRequest $request) : JsonResponse
    {
        $groupId = (int) $request->route('clientId');
        $validated = $this->convertToObject($request->validated());

        if($groupDetails = $this->clientsService->update($validated, $groupId)) {
            return $this->jsonResponse('You have been updated client!', $groupDetails, $this->successCreatedCode, $this->startTime);
        } else {
            return $this->jsonResponse('There is no client with given clientId.', [], $this->notFound, $this->startTime);
        }
    }

    public function processSetIsActive(Request $request) : JsonResponse
    {
        $clientId = (int) $request->get('clientId');
        $value = $request->get('type');

        if($groupDetails = $this->clientsService->setIsActive($clientId, $value)) {
            if($value == 1) {
                return $this->jsonResponse('You have been deactive client!', $groupDetails, $this->successCreatedCode, $this->startTime);
            } else {
                return $this->jsonResponse('You have been active client!', $groupDetails, $this->successCreatedCode, $this->startTime);
            }
        } else {
            return $this->jsonResponse('There is no user with given clientId.', [], $this->notFound, $this->startTime);
        }
    }
}
