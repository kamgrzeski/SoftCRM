<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaleStoreRequest;
use App\Http\Requests\SaleUpdateRequest;
use App\Jobs\StoreSystemLogJob;
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

    public function processShowSalesDetails($saleId)
    {
        return view('crm.sales.show')->with(['sale' => $this->salesService->loadSale($saleId)]);
    }

    public function processRenderUpdateForm($saleId)
    {
        return view('crm.sales.edit')->with(
            [
                'dataWithPluckOfProducts' => $this->salesService->loadProducts()
            ]
        );
    }

    public function processListOfSales()
    {
        return view('crm.sales.index')->with(
            [
                'sales' => $this->salesService->loadSales(),
                'salesPaginate' => $this->salesService->loadPaginate()
            ]
        );
    }

    public function processStoreSale(SaleStoreRequest $request)
    {
        $storedSaleId = $this->salesService->execute($request->validated(), $this->getAdminId());

        if ($storedSaleId) {
            $this->dispatchSync(new StoreSystemLogJob('SalesModel has been add with id: ' . $storedSaleId, $this->systemLogsService::successCode, auth()->user()));

            return redirect()->to('sales')->with('message_success', $this->getMessage('messages.SuccessSalesStore'));
        } else {
            return redirect()->back()->with('message_success', $this->getMessage('messages.ErrorSalesStore'));
        }
    }

    public function processUpdateSale(SaleUpdateRequest $request, int $saleId)
    {
        if ($this->salesService->update($saleId, $request->validated())) {
            return redirect()->to('sales')->with('message_success', $this->getMessage('messages.SuccessSalesStore'));
        } else {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.ErrorSalesStore'));
        }
    }

    public function processDeleteSale(int $saleId)
    {
        $salesDetails = $this->salesService->loadSale($saleId);
        $salesDetails->delete();

        $this->dispatchSync(new StoreSystemLogJob('SalesModel has been deleted with id: ' . $salesDetails->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('sales')->with('message_success', $this->getMessage('messages.SuccessSalesDelete'));
    }

    public function processSaleSetIsActive(int $saleId, bool $value)
    {
        if ($this->salesService->loadIsActive($saleId, $value)) {
            $this->dispatchSync(new StoreSystemLogJob('SalesModel has been enabled with id: ' . $saleId, $this->systemLogsService::successCode, auth()->user()));

            $msg = $value ? 'SuccessSalesActive' : 'SalesIsNowDeactivated';

            return redirect()->to('sales')->with('message_success', $this->getMessage('messages.' . $msg));
        } else {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.ErrorSalesActive'));
        }
    }
}
