<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaleStoreRequest;
use App\Http\Requests\SaleUpdateRequest;
use App\Services\ProductsService;
use App\Services\SalesService;
use App\Services\SystemLogService;
use View;
Use Illuminate\Support\Facades\Redirect;

class SalesController extends Controller
{
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
        return View::make('crm.sales.create')->with(['dataOfProducts' => $this->productsService->loadProducts()]);
    }

    public function processShowSalesDetails($saleId)
    {
        return View::make('crm.sales.show')->with(['sale' => $this->salesService->loadSale($saleId)]);
    }

    public function processRenderUpdateForm($saleId)
    {
        return View::make('crm.sales.edit')->with(
            [
                'dataWithPluckOfProducts' => $this->salesService->loadProducts()
            ]
        );
    }

    public function processListOfSales()
    {
        return View::make('crm.sales.index')->with(
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
            $this->systemLogsService->loadInsertSystemLogs('SalesModel has been add with id: ' . $storedSaleId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('sales')->with('message_success', $this->getMessage('messages.SuccessSalesStore'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorSalesStore'));
        }
    }

    public function processUpdateSale(SaleUpdateRequest $request, int $saleId)
    {
        if ($this->salesService->update($saleId, $request->validated())) {
            return Redirect::to('sales')->with('message_success', $this->getMessage('messages.SuccessSalesStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorSalesStore'));
        }
    }

    public function processDeleteSale(int $saleId)
    {
        $salesDetails = $this->salesService->loadSale($saleId);
        $salesDetails->delete();

        $this->systemLogsService->loadInsertSystemLogs('SalesModel has been deleted with id: ' . $salesDetails->id, $this->systemLogsService::successCode, $this->getAdminId());

        return Redirect::to('sales')->with('message_success', $this->getMessage('messages.SuccessSalesDelete'));
    }

    public function processSaleSetIsActive(int $saleId, bool $value)
    {
        if ($this->salesService->loadIsActive($saleId, $value)) {
            $this->systemLogsService->loadInsertSystemLogs('SalesModel has been enabled with id: ' . $saleId, $this->systemLogsService::successCode, $this->getAdminId());

            $msg = $value ? 'SuccessSalesActive' : 'SalesIsNowDeactivated';

            return Redirect::to('sales')->with('message_success', $this->getMessage('messages.' . $msg));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorSalesActive'));
        }
    }
}
