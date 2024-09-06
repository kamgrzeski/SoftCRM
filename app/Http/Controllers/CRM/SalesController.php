<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaleStoreRequest;
use App\Http\Requests\SaleUpdateRequest;
use App\Jobs\Sale\StoreSaleJob;
use App\Jobs\Sale\UpdateSaleJob;
use App\Jobs\StoreSystemLogJob;
use App\Models\SalesModel;
use App\Services\ProductsService;
use App\Services\SalesService;
use App\Services\SystemLogService;
use Illuminate\Foundation\Bus\DispatchesJobs;

class SalesController extends Controller
{
    use DispatchesJobs;
    private SalesService $salesService;
    private SystemLogService $systemLogsService;
    private ProductsService $productsService;

    public function __construct(SalesService $salesService, SystemLogService $systemLogService, ProductsService $productsService)
    {
        $this->middleware(SystemEnums::middleWareAuth);

        $this->salesService = $salesService;
        $this->systemLogsService = $systemLogService;
        $this->productsService = $productsService;
    }

    public function processRenderCreateForm()
    {
        return view('crm.sales.create')->with(['dataOfProducts' => $this->productsService->loadProducts()]);
    }

    public function processShowSalesDetails(SalesModel $sale)
    {
        return view('crm.sales.show')->with(['sale' => $sale]);
    }

    public function processRenderUpdateForm(SalesModel $sale)
    {
        return view('crm.sales.edit')->with([
            'sale' => $sale,
            'dataWithPluckOfProducts' => $this->productsService->loadProducts()
        ]);
    }

    public function processListOfSales()
    {
        return view('crm.sales.index')->with([
            'sales' => $this->salesService->loadSales(),
            'salesPaginate' => $this->salesService->loadPaginate()
        ]);
    }

    public function processStoreSale(SaleStoreRequest $request)
    {
        $this->dispatchSync(new StoreSaleJob($request->validated(), auth()->user()));

        $this->dispatchSync(new StoreSystemLogJob('SalesModel has been added.', $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('sales')->with('message_success', $this->getMessage('messages.sale_store'));
    }

    public function processUpdateSale(SaleUpdateRequest $request, SalesModel $sale)
    {
        $this->dispatchSync(new UpdateSaleJob($request->validated(), $sale));

        return redirect()->to('sales')->with('message_success', $this->getMessage('messages.sale_store'));
    }

    public function processDeleteSale(SalesModel $sale)
    {
        $sale->delete();

        $this->dispatchSync(new StoreSystemLogJob('SalesModel has been deleted with id: ' . $sale->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('sales')->with('message_success', $this->getMessage('messages.sale_delete'));
    }

    public function processSaleSetIsActive(SalesModel $sale, bool $value)
    {
        $this->dispatchSync(new UpdateSaleJob(['is_active' => $value], $sale));

        $this->dispatchSync(new StoreSystemLogJob('SalesModel has been enabled with id: ' . $sale->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('sales')->with('message_success', $this->getMessage('messages.sale_update'));
    }
}
