<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsStoreRequest;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;

class ProductsController extends Controller
{
    public function processListOfProducts()
    {
        $collectDataForView = array_merge($this->collectedData(), $this->productsService->loadDataAndPagination());

        return View::make('crm.products.index')->with($collectDataForView);
    }

    public function showCreateForm()
    {
        $collectDataForView = array_merge($this->collectedData(), ['inputText' => $this->getMessage('messages.InputText')]);

        return View::make('crm.products.create')->with($collectDataForView);
    }
    
    public function viewProductsDetails(int $productId)
    {
        $collectDataForView = array_merge($this->collectedData(), ['products' => $this->productsService->loadProduct($productId)]);
        return View::make('crm.products.show')
            ->with($collectDataForView);
    }

    public function showUpdateForm(int $productId)
    {
        $collectDataForView = array_merge($this->collectedData(), ['products' => $this->productsService->loadProduct($productId)],
            ['inputText' => $this->getMessage('messages.InputText')]);

        return View::make('crm.products.edit')->with($collectDataForView);
    }
    
    public function processCreateProducts(ProductsStoreRequest $request)
    {
        if ($product = $this->productsService->execute($request->validated())) {
            $this->systemLogsService->insertSystemLogs('Product has been add with id: '. $product, $this->systemLogsService::successCode);
            return Redirect::to('products')->with('message_success', $this->getMessage('messages.SuccessProductsStore'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorProductsStore'));
        }
    }

    public function processUpdateProducts(Request $request, int $productId)
    {
        if ($this->productsService->update($productId, $request->all())) {
            return Redirect::to('products')->with('message_success', $this->getMessage('messages.SuccessProductsStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorProductsStore'));
        }
    }

    public function processDeleteProducts(int $productId)
    {
        $clientAssigned = $this->productsService->checkIfProductHaveAssignedSale($productId);

        if (!empty($clientAssigned)) {
            return Redirect::back()->with('message_danger', $clientAssigned);
        } else {
            $productsDetails = $this->productsService->loadProduct($productId);
            $productsDetails->delete();
        }

        $this->systemLogsService->insertSystemLogs('ProductsModel has been deleted with id: ' . $productsDetails->id, $this->systemLogsService::successCode);

        return Redirect::to('products')->with('message_success', $this->getMessage('messages.SuccessProductsDelete'));
    }

    public function processSetIsActive(int $productId, bool $value)
    {
        if ($this->productsService->loadIsActiveFunction($productId, $value)) {
            $this->systemLogsService->insertSystemLogs('ProductsModel has been enabled with id: ' . $productId, $this->systemLogsService::successCode);
            return Redirect::to('products')->with('message_success', $this->getMessage('messages.SuccessProductsActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ProductsIsActived'));
        }
    }
}
