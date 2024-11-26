<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleStoreRequest;
use App\Http\Requests\SaleUpdateRequest;
use App\Jobs\Sale\StoreSaleJob;
use App\Jobs\Sale\UpdateSaleJob;
use App\Jobs\StoreSystemLogJob;
use App\Models\Sale;
use App\Queries\ProductQueries;
use App\Queries\SaleQueries;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class SalesController
 *
 * Controller for handling sales-related operations in the CRM.
 */
class SalesController extends Controller
{
    use DispatchesJobs;

    /**
     * Render the form for creating a new sale record.
     *
     * @return \Illuminate\View\View
     */
    public function processRenderCreateForm(): \Illuminate\View\View
    {
        // Load the products data to be used in the form.
        return view('crm.sales.create')->with(['products' => ProductQueries::getAll()]);
    }

    /**
     * Show the details of a specific sale record.
     *
     * @param Sale $sale
     * @return \Illuminate\View\View
     */
    public function processShowSalesDetails(Sale $sale): \Illuminate\View\View
    {
        // Load the sale record details.
        return view('crm.sales.show')->with(['sale' => $sale]);
    }

    /**
     * Render the form for updating an existing sale record.
     *
     * @param Sale $sale
     * @return \Illuminate\View\View
     */
    public function processRenderUpdateForm(Sale $sale): \Illuminate\View\View
    {
        // Load the sale record details and the products data to be used in the form.
        return view('crm.sales.update')->with([
            'sale' => $sale,
            'products' => ProductQueries::getAll()
        ]);
    }

    /**
     * List all sale records with pagination.
     *
     * @return \Illuminate\View\View
     */
    public function processListOfSales(): \Illuminate\View\View
    {
        // Load the sale records with pagination.
        return view('crm.sales.index')->with([
            'sales' => SaleQueries::getPaginate()
        ]);
    }

    /**
     * Store a new sale record.
     *
     * @param SaleStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processStoreSale(SaleStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        // Dispatch the job to store the sale record.
        $this->dispatchSync(new StoreSaleJob($request->validated(), auth()->user()));

        // Dispatch the job to store the system log.
        $this->dispatchSync(new StoreSystemLogJob('SalesModel has been added.', 201, auth()->user()));

        // Redirect to the sales list page with a success message.
        return redirect()->to('sales')->with('message_success', $this->getMessage('messages.sale_store'));
    }

    /**
     * Update an existing sale record.
     *
     * @param SaleUpdateRequest $request
     * @param Sale $sale
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processUpdateSale(SaleUpdateRequest $request, Sale $sale): \Illuminate\Http\RedirectResponse
    {
        // Dispatch the job to update the sale record.
        $this->dispatchSync(new UpdateSaleJob($request->validated(), $sale));

        // Dispatch the job to store the system log.
        return redirect()->to('sales')->with('message_success', $this->getMessage('messages.sale_store'));
    }

    /**
     * Delete a sale record.
     *
     * @param Sale $sale
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processDeleteSale(Sale $sale): \Illuminate\Http\RedirectResponse
    {
        // Delete the sale record.
        $sale->delete();

        // Dispatch the job to store the system log.
        $this->dispatchSync(new StoreSystemLogJob('SalesModel has been deleted with id: ' . $sale->id, 201, auth()->user()));

        // Redirect to the sales list page with a success message.
        return redirect()->to('sales')->with('message_success', $this->getMessage('messages.sale_delete'));
    }

    /**
     * Set the active status of a sale record.
     *
     * @param Sale $sale
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processSaleSetIsActive(Sale $sale): \Illuminate\Http\RedirectResponse
    {
        // Dispatch the job to update the sale record.
        $this->dispatchSync(new UpdateSaleJob(['is_active' => ! $sale->is_active], $sale));

        // Dispatch the job to store the system log.
        $this->dispatchSync(new StoreSystemLogJob('SalesModel has been enabled with id: ' . $sale->id, 201, auth()->user()));

        // Redirect to the sales list page with a success message.
        return redirect()->to('sales')->with('message_success', $this->getMessage('messages.sale_update'));
    }
}
