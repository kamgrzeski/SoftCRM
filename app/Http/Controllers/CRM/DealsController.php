<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\DealStoreRequest;
use App\Http\Requests\DealUpdateRequest;
use App\Http\Requests\StoreDealTermRequest;
use App\Jobs\Deal\StoreDealJob;
use App\Jobs\Deal\StoreDealTermJob;
use App\Jobs\Deal\UpdateDealJob;
use App\Jobs\StoreSystemLogJob;
use App\Models\DealsModel;
use App\Models\DealsTermsModel;
use App\Queries\CompaniesQueries;
use App\Services\DealsService;
use App\Services\SystemLogService;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class DealsController
 *
 * Controller for handling deal-related operations in the CRM.
 */
class DealsController extends Controller
{
    use DispatchesJobs;
    private DealsService $dealsService;
    private SystemLogService $systemLogsService;

    /**
     * DealsController constructor.
     *
     * @param DealsService $dealsService
     * @param SystemLogService $systemLogService
     */
    public function __construct(DealsService $dealsService, SystemLogService $systemLogService)
    {
        $this->middleware(self::MIDDLEWARE_AUTH);

        $this->dealsService = $dealsService;
        $this->systemLogsService = $systemLogService;
    }

    /**
     * Render the form for creating a new deal record.
     *
     * @return \Illuminate\View\View
     */
    public function processRenderCreateForm(): \Illuminate\View\View
    {
        // Load the companies for the dropdown.
        return view('crm.deals.create')->with(['companies' => CompaniesQueries::getAll()]);
    }

    /**
     * Show the details of a specific deal record.
     *
     * @param DealsModel $deal
     * @return \Illuminate\View\View
     */
    public function processShowDealsDetails(DealsModel $deal): \Illuminate\View\View
    {
        // Load the deal record details.
        return view('crm.deals.show')->with(['deal' => $deal]);
    }

    /**
     * List all deal records with pagination.
     *
     * @return \Illuminate\View\View
     */
    public function processListOfDeals()
    {
        return view('crm.deals.index')->with([
            'dealsPaginate' => $this->dealsService->loadPaginate()
        ]);
    }

    /**
     * Render the form for updating an existing deal record.
     *
     * @param DealsModel $deal
     * @return \Illuminate\View\View
     */
    public function processRenderUpdateForm(DealsModel $deal): \Illuminate\View\View
    {
        // Load the deal record for editing.
        return view('crm.deals.edit')->with([
            'deal' => $deal,
            'companies' => CompaniesQueries::getAll(),
        ]);
    }

    /**
     * Store a new deal record.
     *
     * @param DealStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processStoreDeal(DealStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        // Store the deal record.
        $this->dispatchSync(new StoreDealJob($request->validated(), auth()->user()));

        // Log the action.
        $this->dispatchSync(new StoreSystemLogJob('Deal has been added.', $this->systemLogsService::successCode, auth()->user()));

        // Redirect back with a success message.
        return redirect()->to('deals')->with('message_success', $this->getMessage('messages.deal_store'));
    }

    /**
     * Update an existing deal record.
     *
     * @param DealUpdateRequest $request
     * @param DealsModel $deal
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processUpdateDeal(DealUpdateRequest $request, DealsModel $deal)
    {
        // Update the deal record.
        $this->dispatchSync(new UpdateDealJob($request->validated(), $deal));

        // Log the action.
        return redirect()->to('deals')->with('message_success', $this->getMessage('messages.deal_update'));
    }

    /**
     * Delete a deal record.
     *
     * @param DealsModel $deal
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processDeleteDeal(DealsModel $deal): \Illuminate\Http\RedirectResponse
    {
        // Check if the deal has any deal terms.
        if ($deal->dealTerms()->count() > 0) {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.deal_first_delete_deal|_term'));
        }

        // Delete the deal record.
        $deal->delete();

        // Log the action.
        $this->dispatchSync(new StoreSystemLogJob('Deals has been deleted with id: ' . $deal->id, $this->systemLogsService::successCode, auth()->user()));

        // Redirect back with a success message.
        return redirect()->to('deals')->with('message_success', $this->getMessage('messages.deal_delete'));
    }

    /**
     * Set the active status of a deal record.
     *
     * @param DealsModel $deal
     * @param bool $value
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processSetIsActive(DealsModel $deal, bool $value): \Illuminate\Http\RedirectResponse
    {
        // Update the deal status.
        $this->dispatchSync(new UpdateDealJob(['is_active' => $value], $deal));

        // Log the action.
        $this->dispatchSync(new StoreSystemLogJob('Deals has been enabled with id: ' . $deal->id, $this->systemLogsService::successCode, auth()->user()));

        // Redirect back with a success message.
        return redirect()->to('deals')->with('message_success', $this->getMessage('messages.' . $value ? 'deal_update' : 'deal_update'));
    }

    /**
     * Store new deal terms.
     *
     * @param StoreDealTermRequest $request
     * @param DealsModel $deal
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processStoreDealTerms(StoreDealTermRequest $request, DealsModel $deal): \Illuminate\Http\RedirectResponse
    {
        // Store the deal terms.
        $this->dispatchSync(new StoreDealTermJob($request->validated(), $deal));

        // Log the action.
        $this->dispatchSync(new StoreSystemLogJob('Deals terms has been added.', $this->systemLogsService::successCode, auth()->user()));

        // Redirect back with a success message.
        return redirect()->back()->with('message_success', $this->getMessage('messages.deal_term_store'));
    }

    /**
     * Generate deal terms in PDF format.
     *
     * @param DealsTermsModel $dealTerm
     * @param DealsModel $deal
     * @return mixed
     */
    public function processGenerateDealTermsInPDF(DealsTermsModel $dealTerm, DealsModel $deal): mixed
    {
        // Load the deal terms in PDF format.
        return $this->dealsService->loadGenerateDealTermsInPDF($dealTerm, $deal);
    }

    /**
     * Delete a deal term record.
     *
     * @param DealsTermsModel $dealTerm
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processDeleteDealTerm(DealsTermsModel $dealTerm): \Illuminate\Http\RedirectResponse
    {
        // Check if the deal term has been used in any deal
        $dealTerm->delete();

        // Log the action.
        $this->dispatchSync(new StoreSystemLogJob('Deal terms has been deleted with id: ' . $dealTerm->id, $this->systemLogsService::successCode, auth()->user()));

        // Redirect back with a success message.
        return redirect()->back()->with('message_success', $this->getMessage('messages.deal_term_delete'));
    }
}
