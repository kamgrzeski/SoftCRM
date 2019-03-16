<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\DealsStoreRequest;
use App\Services\DealsService;
use App\Services\SystemLogService;
use App\Traits\Language;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;

class DealsController extends Controller
{
    use Language;

    private $systemLogs;
    private $dealsService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->dealsService = new DealsService();
    }

    private function getDataAndPagination()
    {
        $dataOfDeals = [
            'deals' => $this->dealsService->loadDeals(),
            'dealsPaginate' => $this->dealsService->loadPaginate()
        ];

        return $dataOfDeals;
    }

    public function index()
    {
        return View::make('crm.deals.index')->with($this->getDataAndPagination());
    }

    public function create()
    {
        return View::make('crm.deals.create')->with([
            'dataOfDeals' => $this->dealsService->pluckCompanies(),
            'inputText' => $this->getMessage('messages.InputText')
        ]);
    }

    public function show(int $dealId)
    {
        return View::make('crm.deals.show')
            ->with('deals', $this->dealsService->loadDeal($dealId));
    }

    public function edit(int $dealId)
    {
        return View::make('crm.deals.edit')
            ->with([
                'deals' => $this->dealsService->loadDeal($dealId),
                'companies' => $this->dealsService->pluckCompanies(),
                'inputText' => $this->getMessage('messages.InputText')
            ]);
    }

    public function store(DealsStoreRequest $request)
    {
        if ($deal = $this->dealsService->execute($request->validated())) {
            $this->systemLogs->insertSystemLogs('Deal has been add with id: '. $deal, $this->systemLogs::successCode);
            return Redirect::to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorDealsStore'));
        }
    }

    public function update(Request $request, int $dealId)
    {
        if ($this->dealsService->update($dealId, $request->all())) {
            return Redirect::to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsUpdate'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorDealsUpdate'));
        }
    }

    public function destroy(int $dealId)
    {
        $dataOfDeals = $this->dealsService->loadDeal($dealId);
        $dataOfDeals->delete();

        $this->systemLogs->insertSystemLogs('DealsModel has been deleted with id: ' .$dataOfDeals->id, $this->systemLogs::successCode);

        return Redirect::to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsDelete'));
    }

    public function processSetIsActive(int $dealId, bool $value)
    {
        if ($this->dealsService->loadSetActive($dealId, $value)) {
            $this->systemLogs->insertSystemLogs('DealsModel has been enabled with id: ' .$dealId, $this->systemLogs::successCode);
            return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessDealsActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorDealsActive'));
        }
    }
}
