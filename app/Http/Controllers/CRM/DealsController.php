<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\DealStoreRequest;
use App\Http\Requests\DealsTermsStoreRequest;
use App\Http\Requests\DealUpdateRequest;
use App\Services\DealsService;
use App\Services\SystemLogService;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;

class DealsController extends Controller
{
    private DealsService $dealsService;
    private SystemLogService $systemLogsService;

    public function __construct(DealsService $dealsService, SystemLogService $systemLogService)
    {
        $this->middleware(SystemEnums::middleWareAuth);

        $this->dealsService = $dealsService;
        $this->systemLogsService = $systemLogService;
    }

    public function processRenderCreateForm()
    {
        return View::make('crm.deals.create')->with(['dataOfDeals' => $this->dealsService->pluckDeals()]);
    }

    public function processShowDealsDetails(int $dealId)
    {
        return View::make('crm.deals.show')->with(['deal' => $this->dealsService->loadDeal($dealId), 'dealsTerms' => $this->dealsService->loadDealsTerms($dealId)]);
    }

    public function processListOfDeals()
    {
        return View::make('crm.deals.index')->with(
            [
                'deals' => $this->dealsService->loadDeals(),
                'dealsPaginate' => $this->dealsService->loadPaginate()
            ]
        );
    }

    public function processRenderUpdateForm(int $dealId)
    {
        return View::make('crm.deals.edit')->with(
            [
                'deal' => $this->dealsService->loadDeal($dealId),
                'companies' => $this->dealsService->pluckDeals()
            ]
        );
    }

    public function processStoreDeal(DealStoreRequest $request)
    {
        $storedDealId = $this->dealsService->execute($request->validated(), $this->getAdminId());

        if ($storedDealId) {
            $this->systemLogsService->loadInsertSystemLogs('Deal has been add with id: ' . $storedDealId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorDealsStore'));
        }
    }

    public function processUpdateDeal(DealUpdateRequest $request, int $dealId)
    {
        if ($this->dealsService->update($dealId, $request->validated())) {
            return Redirect::to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsUpdate'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorDealsUpdate'));
        }
    }

    public function processDeleteDeal(int $dealId)
    {
        $countDealTerms = $this->dealsService->countDealTerms($dealId);

        if ($countDealTerms > 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.firstDeleteDealTerms'));
        }

        $dataOfDeals = $this->dealsService->loadDeal($dealId);
        $dataOfDeals->delete();

        $this->systemLogsService->loadInsertSystemLogs('Deals has been deleted with id: ' . $dataOfDeals->id, $this->systemLogsService::successCode, $this->getAdminId());

        return Redirect::to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsDelete'));
    }

    public function processSetIsActive(int $dealId, bool $value)
    {
        if ($this->dealsService->loadSetActive($dealId, $value)) {
            $this->systemLogsService->loadInsertSystemLogs('Deals has been enabled with id: ' . $dealId, $this->systemLogsService::successCode, $this->getAdminId());

            $msg = $value ? 'SuccessDealsActive' : 'DealsIsNowDeactivated';

            return Redirect::to('deals')->with('message_success', $this->getMessage('messages.' . $msg));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorDealsActive'));
        }
    }

    public function processStoreDealTerms(Request $request)
    {
        $validatedData = $request->all();

        if ($this->dealsService->loadStoreDealTerms($validatedData)) {
            $this->systemLogsService->loadInsertSystemLogs('Deals terms has been enabled with id: ' . $validatedData['dealId'], $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessDealTermStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorDealTermStore'));
        }
    }

    public function processGenerateDealTermsInPDF(Request $request)
    {
        $termId = $request->get('termId');
        $dealId = $request->get('dealId');

        return $this->dealsService->loadGenerateDealTermsInPDF($termId, $dealId);
    }

    public function processDeleteDealTerm(Request $request)
    {
        $termId = $request->get('termId');

        $this->dealsService->loadDeleteTerm($termId);

        $this->systemLogsService->loadInsertSystemLogs('Deal terms has been deleted with id: ' . $termId, $this->systemLogsService::successCode, $this->getAdminId());

        return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessDealsTermDelete'));
    }
}
