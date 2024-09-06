<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Jobs\StoreSystemLogJob;
use App\Services\CompaniesService;
use App\Services\DealsService;
use App\Services\SystemLogService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Redirect;

class CompaniesController extends Controller
{
    use DispatchesJobs;
    private CompaniesService $companiesService;
    private SystemLogService $systemLogsService;
    private DealsService $dealsService;

    public function __construct(CompaniesService $companiesService, SystemLogService $systemLogService, DealsService $dealsService)
    {
        $this->middleware(SystemEnums::middleWareAuth);

        $this->companiesService = $companiesService;
        $this->systemLogsService = $systemLogService;
        $this->dealsService = $dealsService;
    }

    public function processRenderCreateForm()
    {
        return view('crm.companies.create')->with(['dataWithPluckOfClient' => $this->companiesService->pluckData()]);
    }

    public function processViewCompanyDetails(int $companiesId)
    {
        return view('crm.companies.show')->with(['company' => $this->companiesService->loadCompany($companiesId)]);
    }

    public function processListOfCompanies()
    {
        return view('crm.companies.index')->with(
            [
                'companiesPaginate' => $this->companiesService->loadPagination()
            ]
        );
    }

    public function processRenderUpdateForm(int $companiesId)
    {
        return view('crm.companies.edit')->with(
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
            $this->dispatchSync(new StoreSystemLogJob('CompaniesModel has been add with id: ' . $storedCompanyId, $this->systemLogsService::successCode, auth()->user()));

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
        $countDeals = $this->dealsService->loadCountAssignedDeals($companiesId);

        if ($countDeals > 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.firstDeleteDeals'));
        }

        $dataOfCompanies->delete();

        $this->dispatchSync(new StoreSystemLogJob('CompaniesModel has been deleted with id: ' . $dataOfCompanies->id, $this->systemLogsService::successCode, auth()->user()));

        return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesDelete'));
    }

    public function processCompanySetIsActive(int $companiesId, bool $value)
    {
        if ($this->companiesService->loadSetActive($companiesId, $value)) {
            $this->dispatchSync(new StoreSystemLogJob('CompaniesModel has been enabled with id: ' . $companiesId, $this->systemLogsService::successCode, auth()->user()));

            $msg = $value ? 'SuccessCompaniesActive' : 'CompaniesIsNowDeactivated';

            return Redirect::to('companies')->with('message_success', $this->getMessage('messages.' . $msg));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorCompaniesActive'));
        }
    }
}
