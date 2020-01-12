<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsStoreRequest;
use App\Services\ProductsService;
use App\Services\SystemLogService;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;

class ProductsController extends Controller
{
    private $productsService;
    private $systemLogsService;

    public function __construct()
    {
        $this->middleware('auth');

        $this->productsService = new ProductsService();
        $this->systemLogsService = new SystemLogService();
    }

    public function processRenderCreateForm()
    {
        return View::make('crm.products.create');
    }

    public function processShowProductsDetails(int $productId)
    {
        return View::make('crm.products.show')->with(['product' => $this->productsService->loadProduct($productId)]);
    }

    public function processRenderUpdateForm(int $productId)
    {
        return View::make('crm.products.edit')->with(['product' => $this->productsService->loadProduct($productId)]);
    }

    public function processListOfProducts()
    {
        return View::make('crm.products.index')->with(
            [
                'products' => $this->productsService->loadProducts(),
                'productsPaginate' => $this->productsService->loadPagination()
            ]
        );
    }

    public function processStoreProduct(ProductsStoreRequest $request)
    {
        if ($productId = $this->productsService->execute($request->validated(), $this->getAdminId())) {
            $this->systemLogsService->loadInsertSystemLogs('Product has been add with id: ' . $productId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('products')->with('message_success', $this->getMessage('messages.SuccessProductsStore'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorProductsStore'));
        }
    }

    public function processUpdateProduct(Request $request, int $productId)
    {
        if ($this->productsService->update($productId, $request->all())) {
            return Redirect::to('products')->with('message_success', $this->getMessage('messages.SuccessProductsStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorProductsStore'));
        }
    }

    public function processDeleteProduct(int $productId)
    {
        $clientAssigned = $this->productsService->checkIfProductHaveAssignedSale($productId);

        if (!empty($clientAssigned)) {
            return Redirect::back()->with('message_danger', $clientAssigned);
        } else {
            $productsDetails = $this->productsService->loadProduct($productId);
            $productsDetails->delete();
        }

        $this->systemLogsService->loadInsertSystemLogs('ProductsModel has been deleted with id: ' . $productsDetails->id, $this->systemLogsService::successCode, $this->getAdminId());

        return Redirect::to('products')->with('message_success', $this->getMessage('messages.SuccessProductsDelete'));
    }

    public function processSetIsActive(int $productId, bool $value)
    {
        if ($this->productsService->loadIsActiveFunction($productId, $value)) {
            $this->systemLogsService->loadInsertSystemLogs('ProductsModel has been enabled with id: ' . $productId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('products')->with('message_success', $this->getMessage('messages.SuccessProductsActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ProductsIsActived'));
        }
    }
}
