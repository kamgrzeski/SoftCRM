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

    public function processListOfCompanies()
    {
        return View::make('crm.companies.index')->with($this->companiesService->loadDataAndPagination());
    }

    public function showCreateForm()
    {
        return View::make('crm.companies.create')->with([
            'dataWithPluckOfClient' => $this->companiesService->pluckData(),
            'inputText' => $this->getMessage('messages.InputText')
        ]);
    }

    public function viewCompaniesDetails(int $companieId)
    {
        return View::make('crm.companies.show')
            ->with([
                'companies' => $this->companiesService->loadCompanie($companieId)
            ]);
    }

    public function showUpdateForm(int $companieId)
    {
        return View::make('crm.companies.edit')
            ->with([
                'companies' => $this->companiesService->loadCompanie($companieId),
                'clients' => $this->companiesService->pluckData(),
                'inputText' => $this->getMessage('messages.InputText')
            ]);
    }

    public function processCreateCompanies(CompaniesStoreRequest $request)
    {
        if ($companie = $this->companiesService->execute($request->validated())) {
            $this->systemLogs->insertSystemLogs('CompaniesModel has been add with id: '. $companie, $this->systemLogs::successCode);
            return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorCompaniesStore'));
        }
    }

    public function processUpdateCompanies(Request $request, int $companieId)
    {
        if ($this->companiesService->update($companieId, $request->all())) {
            return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesUpdate'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorCompaniesUpdate'));
        }
    }

    public function processDeleteCompanies(int $companieId)
    {
        $dataOfCompanies = $this->companiesService->loadCompanie($companieId);

        $countDeals = $this->companiesService->countAssignedDeals($dataOfCompanies);

        if ($countDeals > 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.firstDeleteDeals'));
        }

        $dataOfCompanies->delete();

        $this->systemLogs->insertSystemLogs('CompaniesModel has been deleted with id: ' . $dataOfCompanies->id, $this->systemLogs::successCode);

        return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesDelete'));
    }

    public function processSetIsActive(int $companieId, bool $value)
    {
        if ($this->companiesService->loadSetActive($companieId, $value)) {
            $this->systemLogs->insertSystemLogs('CompaniesModel has been enabled with id: ' . $companieId, $this->systemLogs::successCode);
            return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorCompaniesActive'));
        }
    }
}
