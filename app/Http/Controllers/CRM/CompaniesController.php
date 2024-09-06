<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Jobs\Company\StoreCompanyJob;
use App\Jobs\Company\UpdateCompanyJob;
use App\Jobs\StoreSystemLogJob;
use App\Models\CompaniesModel;
use App\Queries\ClientsQueries;
use App\Services\CompaniesService;
use App\Services\DealsService;
use App\Services\SystemLogService;
use Illuminate\Foundation\Bus\DispatchesJobs;

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
        return view('crm.companies.create')->with(['dataWithPluckOfClient' => ClientsQueries::getAll()]);
    }

    public function processViewCompanyDetails(CompaniesModel $company)
    {
        return view('crm.companies.show')->with(['company' => $company]);
    }

    public function processListOfCompanies()
    {
        return view('crm.companies.index')->with([
            'companiesPaginate' => $this->companiesService->loadPagination()
        ]);
    }

    public function processRenderUpdateForm(CompaniesModel $company)
    {
        return view('crm.companies.edit')->with([
            'company' => $company,
            'clients' => ClientsQueries::getAll()
        ]);
    }

    public function processStoreCompany(CompanyStoreRequest $request)
    {
        $this->dispatchSync(new StoreCompanyJob($request->validated(), auth()->user()));

        $this->dispatchSync(new StoreSystemLogJob('CompaniesModel has been added.', $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('companies')->with('message_success', $this->getMessage('messages.companies_store'));
    }

    public function processUpdateCompany(CompanyUpdateRequest $request, CompaniesModel $company)
    {
        $this->dispatchSync(new UpdateCompanyJob($request->validated(), $company));

        return redirect()->to('companies')->with('message_success', $this->getMessage('messages.companies_update'));
    }

    public function processDeleteCompany(CompaniesModel $company)
    {
        // Check if company has deals.
        if ($company->deals()->count() > 0) {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.first_delete_deals'));
        }

        // Delete company.
        $company->delete();

        // Store system log.
        $this->dispatchSync(new StoreSystemLogJob('CompaniesModel has been deleted with id: ' . $company->id, $this->systemLogsService::successCode, auth()->user()));

        // Redirect back with message.
        return redirect()->to('companies')->with('message_success', $this->getMessage('messages.companies_delete'));
    }

    public function processCompanySetIsActive(CompaniesModel $company, bool $value)
    {
        // Update company status.
        $this->dispatchSync(new UpdateCompanyJob(['is_active' => $value], $company));

        // Store system log.
        $this->dispatchSync(new StoreSystemLogJob('CompaniesModel has been updated.', $this->systemLogsService::successCode, auth()->user()));

        // Redirect back with message.
        return redirect()->back()->with('message_success', $this->getMessage('messages.companies_update'));
    }
}
