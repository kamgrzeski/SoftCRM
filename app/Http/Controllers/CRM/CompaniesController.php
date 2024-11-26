<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Jobs\Company\StoreCompanyJob;
use App\Jobs\Company\UpdateCompanyJob;
use App\Jobs\StoreSystemLogJob;
use App\Models\Company;
use App\Queries\ClientQueries;
use App\Queries\CompanyQueries;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class CompaniesController
 *
 * Controller for handling company-related operations in the CRM.
 */
class CompaniesController extends Controller
{
    use DispatchesJobs;

    /**
     * Render the form for creating a new company record.
     *
     * @return \Illuminate\View\View
     */
    public function processRenderCreateForm(): \Illuminate\View\View
    {
        // Return view with clients.
        return view('crm.companies.create')->with(['clients' => ClientQueries::getAll()]);
    }

    /**
     * Show the details of a specific company record.
     *
     * @param Company $company
     * @return \Illuminate\View\View
     */
    public function processViewCompanyDetails(Company $company): \Illuminate\View\View
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
            'companies' => CompanyQueries::getPaginate()
        ]);
    }

    /**
     * Render the form for updating an existing company record.
     *
     * @param Company $company
     * @return \Illuminate\View\View
     */
    public function processRenderUpdateForm(Company $company): \Illuminate\View\View
    {
        // Return view with company and clients
        return view('crm.companies.update')->with([
            'company' => $company,
            'clients' => ClientQueries::getAll()
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
        $this->dispatchSync(new StoreSystemLogJob('CompaniesModel has been added.', 201, auth()->user()));

        // Redirect back with message.
        return redirect()->to('companies')->with('message_success', $this->getMessage('messages.companies_store'));
    }

    /**
     * Update an existing company record.
     *
     * @param CompanyUpdateRequest $request
     * @param Company $company
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processUpdateCompany(CompanyUpdateRequest $request, Company $company): \Illuminate\Http\RedirectResponse
    {
        // Update company.
        $this->dispatchSync(new UpdateCompanyJob($request->validated(), $company));

        // Store system log.
        return redirect()->to('companies')->with('message_success', $this->getMessage('messages.companies_update'));
    }

    /**
     * Delete a company record.
     *
     * @param Company $company
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processDeleteCompany(Company $company): \Illuminate\Http\RedirectResponse
    {
        // Check if company has deals.
        if ($company->deals()->count() > 0) {
            return redirect()->back()->with('message_error', $this->getMessage('messages.first_delete_deals'));
        }

        // Delete company.
        $company->delete();

        // Store system log.
        $this->dispatchSync(new StoreSystemLogJob('CompaniesModel has been deleted with id: ' . $company->id, 201, auth()->user()));

        // Redirect back with message.
        return redirect()->to('companies')->with('message_success', $this->getMessage('messages.companies_delete'));
    }

    /**
     * Set the active status of a company record.
     *
     * @param Company $company
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processCompanySetIsActive(Company $company): \Illuminate\Http\RedirectResponse
    {
        // Update company status.
        $this->dispatchSync(new UpdateCompanyJob(['is_active' => ! $company->is_active], $company));

        // Store system log.
        $this->dispatchSync(new StoreSystemLogJob('CompaniesModel has been updated.', 201, auth()->user()));

        // Redirect back with message.
        return redirect()->back()->with('message_success', $this->getMessage('messages.companies_update'));
    }
}
