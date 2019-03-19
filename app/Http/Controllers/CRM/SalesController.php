<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesStoreRequest;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;

class SalesController extends Controller
{
    public function processListOfSales()
    {
        $collectDataForView = array_merge($this->collectedData(), $this->salesService->loadDataAndPagination());

        return View::make('crm.sales.index')->with($collectDataForView);
    }
    
    public function showCreateForm()
    {
        $collectDataForView = array_merge($this->collectedData(), ['dataOfProducts' => $this->salesService->loadProducts()]);

        return View::make('crm.sales.create')->with($collectDataForView);
    }
    
    public function viewSalesDetails($saleId)
    {
        $collectDataForView = array_merge($this->collectedData(), ['sales' => $this->salesService->loadSale($saleId)]);

        return View::make('crm.sales.show')->with($collectDataForView);
    }

    public function showUpdateForm($saleId)
    {
        $collectDataForView = array_merge($this->collectedData(), ['sales' => $this->salesService->loadSale($saleId)],
            ['dataWithPluckOfProducts' => $this->salesService->loadProducts()]);

        return View::make('crm.sales.edit')->with($collectDataForView);
    }

    public function processCreateSales(SalesStoreRequest $request)
    {
        if ($sale = $this->salesService->execute($request->validated())) {
            $this->systemLogsService->insertSystemLogs('SalesModel has been add with id: ' . $sale, $this->systemLogsService::successCode);
            return Redirect::to('sales')->with('message_success', $this->getMessage('messages.SuccessSalesStore'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorSalesStore'));
        }
    }

    public function processUpdateSales(Request $request, int $saleId)
    {
        if ($this->salesService->update($saleId, $request->all())) {
            return Redirect::to('sales')->with('message_success', $this->getMessage('messages.SuccessSalesStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorSalesStore'));
        }
    }

    public function processDeleteSales(int $saleId)
    {
        $salesDetails = $this->salesService->loadSale($saleId);
        $salesDetails->delete();

        $this->systemLogsService->insertSystemLogs('SalesModel has been deleted with id: ' . $salesDetails->id, $this->systemLogsService::successCode);

        return Redirect::to('sales')->with('message_success', $this->getMessage('messages.SuccessSalesDelete'));
    }

    public function processSetIsActive(int $saleId, bool $value)
    {
        if ($this->salesService->loadIsActiveFunction($saleId, $value)) {
            $this->systemLogsService->insertSystemLogs('SalesModel has been enabled with id: ' . $saleId, $this->systemLogsService::successCode);
            return Redirect::to('sales')->with('message_success', $this->getMessage('messages.SuccessSalesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.SalesIsActived'));
        }
    }
}
