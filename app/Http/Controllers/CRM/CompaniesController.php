<?php

namespace App\Http\Controllers\CRM;

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

/**
 * Class CompaniesController
 *
 * Controller for handling company-related operations in the CRM.
 */
class CompaniesController extends Controller
{
    use DispatchesJobs;
    private CompaniesService $companiesService;
    private SystemLogService $systemLogsService;
    private DealsService $dealsService;

    /**
     * CompaniesController constructor.
     *
     * @param CompaniesService $companiesService
     * @param SystemLogService $systemLogService
     * @param DealsService $dealsService
     */
    public function __construct(CompaniesService $companiesService, SystemLogService $systemLogService, DealsService $dealsService)
    {
        $this->middleware(self::MIDDLEWARE_AUTH);

        $this->companiesService = $companiesService;
        $this->systemLogsService = $systemLogService;
        $this->dealsService = $dealsService;
    }

    /**
     * Render the form for creating a new company record.
     *
     * @return \Illuminate\View\View
     */
    public function processRenderCreateForm(): \Illuminate\View\View
    {
        // Return view with clients.
        return view('crm.companies.create')->with(['dataWithPluckOfClient' => ClientsQueries::getAll()]);
    }

    /**
     * Show the details of a specific company record.
     *
     * @param CompaniesModel $company
     * @return \Illuminate\View\View
     */
    public function processViewCompanyDetails(CompaniesModel $company): \Illuminate\View\View
    {
        // Return view with company details.
        return view('crm.companies.show')->with(['company' => $company]);
    }

    /**
     * List all company records with pagination.
     *
     * @return \Illuminate\View\View
     */
    public function processListOfCompanies(): \Illuminate\View\View
    {
        // Return view with companies pagination.
        return view('crm.companies.index')->with([
            'companiesPaginate' => $this->companiesService->loadPagination()
        ]);
    }

    /**
     * Render the form for updating an existing company record.
     *
     * @param CompaniesModel $company
     * @return \Illuminate\View\View
     */
    public function processRenderUpdateForm(CompaniesModel $company): \Illuminate\View\View
    {
        // Return view with company and clients
        return view('crm.companies.edit')->with([
            'company' => $company,
            'clients' => ClientsQueries::getAll()
        ]);
    }

    /**
     * Store a new company record.
     *
     * @param CompanyStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processStoreCompany(CompanyStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        // Store company.
        $this->dispatchSync(new StoreCompanyJob($request->validated(), auth()->user()));

        // Store system log.
        $this->dispatchSync(new StoreSystemLogJob('CompaniesModel has been added.', $this->systemLogsService::successCode, auth()->user()));

        // Redirect back with message.
        return redirect()->to('companies')->with('message_success', $this->getMessage('messages.companies_store'));
    }

    /**
     * Update an existing company record.
     *
     * @param CompanyUpdateRequest $request
     * @param CompaniesModel $company
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processUpdateCompany(CompanyUpdateRequest $request, CompaniesModel $company): \Illuminate\Http\RedirectResponse
    {
        // Update company.
        $this->dispatchSync(new UpdateCompanyJob($request->validated(), $company));

        // Store system log.
        return redirect()->to('companies')->with('message_success', $this->getMessage('messages.companies_update'));
    }

    /**
     * Delete a company record.
     *
     * @param CompaniesModel $company
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processDeleteCompany(CompaniesModel $company): \Illuminate\Http\RedirectResponse
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

    /**
     * Set the active status of a company record.
     *
     * @param CompaniesModel $company
     * @param bool $value
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processCompanySetIsActive(CompaniesModel $company, bool $value): \Illuminate\Http\RedirectResponse
    {
        // Update company status.
        $this->dispatchSync(new UpdateCompanyJob(['is_active' => $value], $company));

        // Store system log.
        $this->dispatchSync(new StoreSystemLogJob('CompaniesModel has been updated.', $this->systemLogsService::successCode, auth()->user()));

        // Redirect back with message.
        return redirect()->back()->with('message_success', $this->getMessage('messages.companies_update'));
    }
}
