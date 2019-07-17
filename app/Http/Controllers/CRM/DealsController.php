<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\DealsStoreRequest;
use App\Http\Requests\DealsUpdateRequest;
use App\Services\DealsService;
use Illuminate\Http\Request;
use Illuminate\Http\{JsonResponse};

class DealsController extends Controller
{
    private $dealsService;

    public function __construct()
    {
        parent::__construct();

        $this->dealsService = new DealsService();
    }

    public function processListOfDeals() : JsonResponse
    {
        if ($dealsList = $this->dealsService->loadDealsList()) {
            return $this->jsonResponse('Deals list.', $dealsList, $this->successCode, $this->startTime);
        } else {
            return $this->jsonResponse('Something went wrong while collection deal list.', [], $this->unauthorized, $this->startTime);
        }
    }

    public function processCreateDeal(DealsStoreRequest $request) : JsonResponse
    {
        $validatedData = $this->convertToObject($request->validated());

        if ($dealId = $this->dealsService->execute($validatedData)) {
            $this->insertSystemLogs('Deal has been stored. Deal ID: ' . $dealId, $this->successCode);
            return $this->jsonResponse('You have successfully stored deal!', [], $this->successCode, $this->startTime);
        } else {
            return $this->jsonResponse('Something went wrong while storing deal.', [], $this->unauthorized, $this->startTime);
        }
    }

    public function processDealDetails(Request $request) : JsonResponse
    {
        if ($dealDetails = $this->dealsService->loadDealDetails($request->route('dealId'))) {
            return $this->jsonResponse('Deal details', $dealDetails, $this->successCode, $this->startTime);
        } else {
            return $this->jsonResponse('Something went wrong while collecting deal data.', [], $this->unauthorized, $this->startTime);
        }
    }

    public function processDeleteDeal(Request $request) : JsonResponse
    {
        $dealId = $request->route('dealId');

        if ($this->dealsService->loadDealDelete($dealId)) {
            return $this->jsonResponse('Deal has been deleted.', ['dealId' => $dealId], $this->successCode, $this->startTime);
        } else {
            return $this->jsonResponse('Something went wrong while collecting deal data.', [], $this->unauthorized, $this->startTime);
        }
    }

    public function processUpdateDeal(DealsUpdateRequest $request) : JsonResponse
    {
        $groupId = (int) $request->route('dealId');
        $validated = $this->convertToObject($request->validated());

        if($groupDetails = $this->dealsService->update($validated, $groupId)) {
            return $this->jsonResponse('You have been updated deal!', $groupDetails, $this->successCreatedCode, $this->startTime);
        } else {
            return $this->jsonResponse('There is no deal with given dealId.', [], $this->notFound, $this->startTime);
        }
    }

    public function processSetIsActive(Request $request) : JsonResponse
    {
        $dealId = (int) $request->get('dealId');
        $value = $request->get('type');

        if($groupDetails = $this->dealsService->setIsActive($dealId, $value)) {
            if($value == 1) {
                return $this->jsonResponse('You have been deactive deal!', $groupDetails, $this->successCreatedCode, $this->startTime);
            } else {
                return $this->jsonResponse('You have been active deal!', $groupDetails, $this->successCreatedCode, $this->startTime);
            }
        } else {
            return $this->jsonResponse('There is no user with given dealId.', [], $this->notFound, $this->startTime);
        }
    }
}
