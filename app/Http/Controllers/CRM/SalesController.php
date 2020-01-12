<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesStoreRequest;
use App\Services\SalesService;
use App\Services\SystemLogService;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;

class SalesController extends Controller
{
    private $salesService;
    private $systemLogsService;

    public function __construct()
    {
        $this->middleware('auth');

        $this->salesService = new SalesService();
        $this->systemLogsService = new SystemLogService();
    }

    public function processRenderCreateForm()
    {
        return View::make('crm.sales.create')->with(['dataOfProducts' => $this->salesService->loadProducts()]);
    }

    public function processShowSalesDetails($saleId)
    {
        return View::make('crm.sales.show')->with(['sale' => $this->salesService->loadSale($saleId)]);
    }

    public function processRenderUpdateForm($saleId)
    {
        return View::make('crm.sales.edit')->with(
            [
                'sale' => $this->salesService->loadSale($saleId),
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

    public function processStoreSale(SalesStoreRequest $request)
    {
        if ($saleId = $this->salesService->execute($request->validated(), $this->getAdminId())) {
            $this->systemLogsService->loadInsertSystemLogs('SalesModel has been add with id: ' . $saleId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('sales')->with('message_success', $this->getMessage('messages.SuccessSalesStore'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorSalesStore'));
        }
    }

    public function processUpdateSale(Request $request, int $saleId)
    {
        if ($this->salesService->update($saleId, $request->all())) {
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

    public function processSetIsActive(int $saleId, bool $value)
    {
        if ($this->salesService->loadIsActiveFunction($saleId, $value)) {
            $this->systemLogsService->loadInsertSystemLogs('SalesModel has been enabled with id: ' . $saleId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('sales')->with('message_success', $this->getMessage('messages.SuccessSalesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.SalesIsActived'));
        }
    }
}
