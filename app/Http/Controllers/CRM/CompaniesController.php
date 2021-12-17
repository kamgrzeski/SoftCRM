<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Services\CompaniesService;
use App\Services\SystemLogService;
use View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    private CompaniesService $companiesService;
    private SystemLogService $systemLogsService;

    public function __construct(CompaniesService $companiesService, SystemLogService $systemLogService)
    {
        $this->middleware(SystemEnums::middleWareAuth);

        $this->companiesService = $companiesService;
        $this->systemLogsService = $systemLogService;
    }

    public function processRenderCreateForm()
    {
        return View::make('crm.companies.create')->with(['dataWithPluckOfClient' => $this->companiesService->pluckData()]);
    }

    public function processViewCompanyDetails(int $companiesId)
    {
        return View::make('crm.companies.show')->with(['company' => $this->companiesService->loadCompany($companiesId)]);
    }

    public function processListOfCompanies()
    {
        return View::make('crm.companies.index')->with(
            [
                'companies' => $this->companiesService->loadCompanies(),
                'companiesPaginate' => $this->companiesService->loadPagination()
            ]
        );
    }

    public function processRenderUpdateForm(int $companiesId)
    {
        return View::make('crm.companies.edit')->with(
            [
                'company' => $this->companiesService->loadCompany($companiesId),
                'clients' => $this->companiesService->pluckData()
            ]
        );
    }

    public function processStoreCompany(CompanyStoreRequest $request)
    {
        $storedCompanyId = $this->companiesService->execute($request->validated(), $this->getAdminId());

        if ($storedCompanyId) {
            $this->systemLogsService->loadInsertSystemLogs('CompaniesModel has been add with id: ' . $storedCompanyId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorCompaniesStore'));
        }
    }

    public function processUpdateCompany(CompanyUpdateRequest $request, int $companiesId)
    {
        if ($this->companiesService->update($companiesId, $request->validated())) {
            return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesUpdate'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorCompaniesUpdate'));
        }
    }

    public function processDeleteCompany(int $companiesId)
    {
        $dataOfCompanies = $this->companiesService->loadCompany($companiesId);
        $countDeals = $this->companiesService->loadCountAssignedDeals($companiesId);

        if ($countDeals > 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.firstDeleteDeals'));
        }

        $dataOfCompanies->delete();

        $this->systemLogsService->loadInsertSystemLogs('CompaniesModel has been deleted with id: ' . $dataOfCompanies->id, $this->systemLogsService::successCode, $this->getAdminId());

        return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesDelete'));
    }

    public function processCompanySetIsActive(int $companiesId, bool $value)
    {
        if ($this->companiesService->loadSetActive($companiesId, $value)) {
            $this->systemLogsService->loadInsertSystemLogs('CompaniesModel has been enabled with id: ' . $companiesId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorCompaniesActive'));
        }
    }
}
