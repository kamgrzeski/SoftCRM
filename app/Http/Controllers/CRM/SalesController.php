<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleStoreRequest;
use App\Http\Requests\SaleUpdateRequest;
use App\Jobs\Sale\StoreSaleJob;
use App\Jobs\Sale\UpdateSaleJob;
use App\Jobs\StoreSystemLogJob;
use App\Models\SalesModel;
use App\Services\ProductsService;
use App\Services\SalesService;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class SalesController
 *
 * Controller for handling sales-related operations in the CRM.
 */
class SalesController extends Controller
{
    use DispatchesJobs;
    private SalesService $salesService;
    private ProductsService $productsService;

    /**
     * SalesController constructor.
     *
     * @param SalesService $salesService
     * @param ProductsService $productsService
     */
    public function __construct(SalesService $salesService, ProductsService $productsService)
    {
        $this->middleware(self::MIDDLEWARE_AUTH);

        $this->salesService = $salesService;
        $this->productsService = $productsService;
    }

    /**
     * Render the form for creating a new sale record.
     *
     * @return \Illuminate\View\View
     */
    public function processRenderCreateForm(): \Illuminate\View\View
    {
        return view('crm.sales.create')->with(['dataOfProducts' => $this->productsService->loadProducts()]);
    }

    /**
     * Show the details of a specific sale record.
     *
     * @param SalesModel $sale
     * @return \Illuminate\View\View
     */
    public function processShowSalesDetails(SalesModel $sale): \Illuminate\View\View
    {
        return view('crm.sales.show')->with(['sale' => $sale]);
    }

    /**
     * Render the form for updating an existing sale record.
     *
     * @param SalesModel $sale
     * @return \Illuminate\View\View
     */
    public function processRenderUpdateForm(SalesModel $sale): \Illuminate\View\View
    {
        return view('crm.sales.edit')->with([
            'sale' => $sale,
            'dataWithPluckOfProducts' => $this->productsService->loadProducts()
        ]);
    }

    /**
     * List all sale records with pagination.
     *
     * @return \Illuminate\View\View
     */
    public function processListOfSales(): \Illuminate\View\View
    {
        return view('crm.sales.index')->with([
            'sales' => $this->salesService->loadSales(),
            'salesPaginate' => $this->salesService->loadPaginate()
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
        $this->dispatchSync(new StoreSaleJob($request->validated(), auth()->user()));

        $this->dispatchSync(new StoreSystemLogJob('SalesModel has been added.', 201, auth()->user()));

        return redirect()->to('sales')->with('message_success', $this->getMessage('messages.sale_store'));
    }

    /**
     * Update an existing sale record.
     *
     * @param SaleUpdateRequest $request
     * @param SalesModel $sale
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processUpdateSale(SaleUpdateRequest $request, SalesModel $sale): \Illuminate\Http\RedirectResponse
    {
        $this->dispatchSync(new UpdateSaleJob($request->validated(), $sale));

        return redirect()->to('sales')->with('message_success', $this->getMessage('messages.sale_store'));
    }

    /**
     * Delete a sale record.
     *
     * @param SalesModel $sale
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processDeleteSale(SalesModel $sale): \Illuminate\Http\RedirectResponse
    {
        $sale->delete();

        $this->dispatchSync(new StoreSystemLogJob('SalesModel has been deleted with id: ' . $sale->id, 201, auth()->user()));

        return redirect()->to('sales')->with('message_success', $this->getMessage('messages.sale_delete'));
    }

    /**
     * Set the active status of a sale record.
     *
     * @param SalesModel $sale
     * @param bool $value
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processSaleSetIsActive(SalesModel $sale, bool $value): \Illuminate\Http\RedirectResponse
    {
        $this->dispatchSync(new UpdateSaleJob(['is_active' => $value], $sale));

        $this->dispatchSync(new StoreSystemLogJob('SalesModel has been enabled with id: ' . $sale->id, 201, auth()->user()));

        return redirect()->to('sales')->with('message_success', $this->getMessage('messages.sale_update'));
    }
}
