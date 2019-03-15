<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\DealsStoreRequest;
use App\Models\CompaniesModel;
use App\Models\DealsModel;
use App\Services\DealsService;
use App\Services\SystemLogService;
use App\Traits\Language;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class DealsController extends Controller
{
    use Language;

    private $systemLogs;
    private $dealsModel;
    private $dealsService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->dealsModel = new DealsModel();
        $this->dealsService = new DealsService();
    }

    private function getDataAndPagination()
    {
        $dataOfDeals = [
            'deals' => $this->dealsService->getDeals(),
            'dealsPaginate' => $this->dealsService->getPaginate()
        ];

        return $dataOfDeals;
    }

    public function index()
    {
        return View::make('crm.deals.index')->with($this->getDataAndPagination());
    }

    public function create()
    {
        $dataOfDeals = CompaniesModel::pluck('name', 'id');

        return View::make('crm.deals.create')->with([
            'dataOfDeals' => $dataOfDeals,
            'inputText' => $this->getMessage('messages.InputText')
        ]);
    }

    public function show($dealId)
    {
        return View::make('crm.deals.show')
            ->with('deals', $this->dealsService->getDeal($dealId));
    }

    public function edit($dealId)
    {
        $dataWithPluckOfCompanies = CompaniesModel::pluck('name', 'id');

        return View::make('crm.deals.edit')
            ->with([
                'deals' => $this->dealsService->getDeal($dealId),
                'companies' => $dataWithPluckOfCompanies
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

    public function destroy($dealId)
    {
        $dataOfDeals = $this->dealsService->getDeal($dealId);
        $dataOfDeals->delete();

        $this->systemLogs->insertSystemLogs('DealsModel has been deleted with id: ' .$dataOfDeals->id, $this->systemLogs::successCode);

        return Redirect::to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsDelete'));
    }

    public function isActiveFunction($dealId, $value)
    {
        if ($this->dealsModel->setActive($dealId, $value)) {
            $this->systemLogs->insertSystemLogs('DealsModel has been enabled with id: ' .$dealId, $this->systemLogs::successCode);
            return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessDealsActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorDealsActive'));
        }
    }


    public function search()
    {
        return true; // TODO
    }
}
