<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\DealsStoreRequest;
use App\Services\DealsService;
use App\Services\SystemLogService;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;

class DealsController extends Controller
{
    private $dealsService;
    private $systemLogsService;

    public function __construct()
    {
        $this->middleware('auth');

        $this->dealsService = new DealsService();
        $this->systemLogsService = new SystemLogService();
    }

    public function processListOfDeals()
    {
        return View::make('crm.deals.index')->with(['deals' => $this->dealsService->loadDataAndPagination()]);
    }

    public function showCreateForm()
    {
        return View::make('crm.deals.create')->with(['dataOfDeals' => $this->dealsService->pluckCompanies()]);
    }

    public function viewDealsDetails(int $dealId)
    {
        return View::make('crm.deals.show')->with(['deal' => $this->dealsService->loadDeal($dealId)]);
    }

    public function showUpdateForm(int $dealId)
    {
        return View::make('crm.deals.edit')->with(
            [
                'deals' => $this->dealsService->loadDeal($dealId),
                'companies' => $this->dealsService->pluckCompanies()
            ]
        );
    }

    public function processCreateDeals(DealsStoreRequest $request)
    {
        if ($deal = $this->dealsService->execute($request->validated())) {
            $this->systemLogsService->insertSystemLogs('Deal has been add with id: ' . $deal, $this->systemLogsService::successCode);
            return Redirect::to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorDealsStore'));
        }
    }

    public function processUpdateDeals(Request $request, int $dealId)
    {
        if ($this->dealsService->update($dealId, $request->all())) {
            return Redirect::to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsUpdate'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorDealsUpdate'));
        }
    }

    public function processDeleteDeals(int $dealId)
    {
        $dataOfDeals = $this->dealsService->loadDeal($dealId);
        $dataOfDeals->delete();

        $this->systemLogsService->insertSystemLogs('DealsModel has been deleted with id: ' . $dataOfDeals->id, $this->systemLogsService::successCode);

        return Redirect::to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsDelete'));
    }

    public function processSetIsActive(int $dealId, bool $value)
    {
        if ($this->dealsService->loadSetActive($dealId, $value)) {
            $this->systemLogsService->insertSystemLogs('DealsModel has been enabled with id: ' . $dealId, $this->systemLogsService::successCode);
            return Redirect::to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorDealsActive'));
        }
    }
}
