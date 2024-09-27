<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinanceStoreRequest;
use App\Http\Requests\FinanceUpdateRequest;
use App\Jobs\Finance\StoreFinanceJob;
use App\Jobs\Finance\UpdateFinanceJob;
use App\Jobs\StoreSystemLogJob;
use App\Models\FinancesModel;
use App\Queries\CompaniesQueries;
use App\Queries\FinancesQueries;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class FinancesController
 *
 * Controller for handling finance-related operations in the CRM.
 */
class FinancesController extends Controller
{
    use DispatchesJobs;

    /**
     * Render the form for creating a new finance record.
     *
     * @return \Illuminate\View\View
     */
    public function processRenderCreateForm()
    {
        // Return the view with the companies.
        return view('crm.finances.create')->with(['companies' => CompaniesQueries::getAll(true)]);
    }

    /**
     * Show the details of a specific finance record.
     *
     * @param FinancesModel $finance
     * @return \Illuminate\View\View
     */
    public function processShowFinancesDetails(FinancesModel $finance)
    {
        // Return the view with the finance record.
        return view('crm.finances.show')->with(['finance' => $finance]);
    }

    /**
     * List all finance records with pagination.
     *
     * @return \Illuminate\View\View
     */
    public function processListOfFinances()
    {
        // Return the view with the finances and the pagination.
        return view('crm.finances.index')->with([
            'finances' => FinancesQueries::getPaginate()
        ]);
    }

    /**
     * Render the form for updating an existing finance record.
     *
     * @param FinancesModel $finance
     * @return \Illuminate\View\View
     */
    public function processRenderUpdateForm(FinancesModel $finance)
    {
        // Return the view with the finance record and the companies.
        return view('crm.finances.edit')->with([
            'finance' => $finance,
            'companies' => CompaniesQueries::getAll(true)
        ]);
    }

    /**
     * Store a new finance record.
     *
     * @param FinanceStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processStoreFinance(FinanceStoreRequest $request)
    {
        // StoreFinanceJob is a job that stores the finance model.
        $this->dispatchSync(new StoreFinanceJob($request->validated(), auth()->user()));

        // StoreSystemLogJob is a job that stores the system log.
        $this->dispatchSync(new StoreSystemLogJob('FinancesModel has been added.', 201, auth()->user()));

        // Redirect to the finances page with a success message.
        return redirect()->to('finances')->with('message_success', $this->getMessage('messages.finance_store'));
    }

    /**
     * Update an existing finance record.
     *
     * @param FinanceUpdateRequest $request
     * @param FinancesModel $finance
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processUpdateFinance(FinanceUpdateRequest $request, FinancesModel $finance)
    {
        // UpdateFinanceJob is a job that updates the finance model.
        $this->dispatchSync(new UpdateFinanceJob($request->validated(), $finance));

        // StoreSystemLogJob is a job that stores the system log.
        return redirect()->to('finances')->with('message_success', $this->getMessage('messages.finance_update'));
    }

    /**
     * Delete a finance record.
     *
     * @param FinancesModel $finance
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processDeleteFinance(FinancesModel $finance)
    {
        // Check if the finance record has companies.
        $finance->delete();

        // StoreSystemLogJob is a job that stores the system log.
        $this->dispatchSync(new StoreSystemLogJob('FinancesModel has been deleted with id: ' . $finance->id, 201, auth()->user()));

        // Redirect to the finances page with a success message.
        return redirect()->to('finances')->with('message_success', $this->getMessage('messages.finance_delete'));
    }

    /**
     * Set the active status of a finance record.
     *
     * @param FinancesModel $finance
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processFinanceSetIsActive(FinancesModel $finance)
    {
        // UpdateFinanceJob is a job that updates the finance model.
        $this->dispatchSync(new UpdateFinanceJob(['is_active' => ! $finance->is_active], $finance));

        // StoreSystemLogJob is a job that stores the system log.
        $this->dispatchSync(new StoreSystemLogJob('FinancesModel has been enabled with id: ' . $finance->id, 201, auth()->user()));

        // Redirect to the finances page with a success message.
        return redirect()->to('finances')->with('message_success', $this->getMessage('messages.finance_update'));
    }
}
