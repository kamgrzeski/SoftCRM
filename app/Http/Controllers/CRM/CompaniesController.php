<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompaniesStoreRequest;
use App\Services\CompaniesService;
use App\Services\SystemLogService;
use App\Traits\Language;
use View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Config;

class CompaniesController extends Controller
{
    use Language;

    private $systemLogs;
    private $companiesService;
    private $language;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->companiesService = new CompaniesService();
    }

    public function index()
    {
        return View::make('crm.companies.index')->with($this->companiesService->getDataAndPagination());
    }

    public function create()
    {
        return View::make('crm.companies.create')->with([
            'dataWithPluckOfClient' => $this->companiesService->pluckData(),
            'inputText' => $this->getMessage('messages.InputText')
        ]);
    }

    public function show($companieId)
    {
        return View::make('crm.companies.show')
            ->with([
                'companies' => $this->companiesService->loadCompanie($companieId)
            ]);
    }

    public function edit($companieId)
    {
        return View::make('crm.companies.edit')
            ->with([
                'companies' => $this->companiesService->loadCompanie($companieId),
                'clients' => $this->companiesService->pluckData()
            ]);
    }

    public function store(CompaniesStoreRequest $request)
    {
        if ($companie = $this->companiesService->execute($request->validated())) {
            $this->systemLogs->insertSystemLogs('CompaniesModel has been add with id: '. $companie, $this->systemLogs::successCode);
            return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorCompaniesStore'));
        }
    }

    public function update(Request $request, int $companieId)
    {
        if ($this->companiesService->update($companieId, $request->all())) {
            return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesUpdate'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorCompaniesUpdate'));
        }
    }

    public function destroy($companieId)
    {
        $dataOfCompanies = $this->companiesService->loadCompanie($companieId);

        $countDeals = $this->companiesService->countAssignedDeals($dataOfCompanies);
        $countFiles = $this->companiesService->countAssignedFile($dataOfCompanies);
        $countInvoices = $this->companiesService->countAssignedInvoice($dataOfCompanies);

        if ($countDeals > 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.firstDeleteDeals'));
        }

        if ($countFiles > 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.firstDeleteFiles'));
        }

        if ($countInvoices > 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.firstDeleteInvoices'));
        }

        $dataOfCompanies->delete();

        $this->systemLogs->insertSystemLogs('CompaniesModel has been deleted with id: ' . $dataOfCompanies->id, $this->systemLogs::successCode);

        return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesDelete'));
    }

    public function isActiveFunction($companieId, $value)
    {
        if ($this->companiesService->loadSetActiveFunction($companieId, $value)) {
            $this->systemLogs->insertSystemLogs('CompaniesModel has been enabled with id: ' . $companieId, $this->systemLogs::successCode);
            return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorCompaniesActive'));
        }
    }

    public function disable($companieId)
    {
        if ($this->companiesService->loadSetActiveFunction($companieId, FALSE)) {
            $this->systemLogs->insertSystemLogs('CompaniesModel has been disabled with id: ' . $companieId, $this->systemLogs::successCode);
            return Redirect::to('companies')->with('message_success', $this->getMessage('messages.CompaniesIsNowDeactivated'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.CompaniesIsDeactivated'));
        }
    }

    public function search()
    {
        return true; // TODO
    }
}
