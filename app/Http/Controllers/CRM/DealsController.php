<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\DealsStoreRequest;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;

class DealsController extends Controller
{
    public function processListOfDeals()
    {
        $collectDataForView = array_merge($this->collectedData(), ['deals' => $this->dealsService->loadDataAndPagination()]);

        return View::make('crm.deals.index')->with($collectDataForView);
    }

    public function showCreateForm()
    {
        $collectDataForView = array_merge($this->collectedData(), ['dataOfDeals' => $this->dealsService->pluckCompanies()]);

        return View::make('crm.deals.create')->with($collectDataForView);
    }

    public function viewDealsDetails(int $dealId)
    {
        $collectDataForView = array_merge($this->collectedData(), ['deal' => $this->dealsService->loadDeal($dealId)]);

        return View::make('crm.deals.show')->with($collectDataForView);
    }

    public function showUpdateForm(int $dealId)
    {
        $collectDataForView = array_merge($this->collectedData(), ['deals' => $this->dealsService->loadDeal($dealId)], ['companies' => $this->dealsService->pluckCompanies()]);

        return View::make('crm.deals.edit')->with($collectDataForView);
    }

    public function processCreateDeals(DealsStoreRequest $request)
    {
        if ($deal = $this->dealsService->execute($request->validated())) {
            $this->systemLogsService->insertSystemLogs('Deal has been add with id: '. $deal, $this->systemLogsService::successCode);
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

        $this->systemLogsService->insertSystemLogs('DealsModel has been deleted with id: ' .$dataOfDeals->id, $this->systemLogsService::successCode);

        return Redirect::to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsDelete'));
    }

    public function processSetIsActive(int $dealId, bool $value)
    {
        if ($this->dealsService->loadSetActive($dealId, $value)) {
            $this->systemLogsService->insertSystemLogs('DealsModel has been enabled with id: ' .$dealId, $this->systemLogsService::successCode);
            return Redirect::to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorDealsActive'));
        }
    }
}
