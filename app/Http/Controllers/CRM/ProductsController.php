<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Services\ProductsService;
use App\Services\SystemLogService;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;

class ProductsController extends Controller
{
    private ProductsService $productsService;
    private SystemLogService $systemLogsService;

    public function __construct(ProductsService $productsService, SystemLogService $systemLogService)
    {
        $this->middleware(SystemEnums::middleWareAuth);

        $this->productsService = $productsService;
        $this->systemLogsService = $systemLogService;
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

    public function processStoreProduct(ProductStoreRequest $request)
    {
        $storedProductId = $this->productsService->execute($request->validated(), $this->getAdminId());

        if ($storedProductId) {
            $this->systemLogsService->loadInsertSystemLogs('Product has been add with id: ' . $storedProductId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('products')->with('message_success', $this->getMessage('messages.SuccessProductsStore'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorProductsStore'));
        }
    }

    public function processUpdateProduct(ProductUpdateRequest $request, int $productId)
    {
        if ($this->productsService->update($productId, $request->validated())) {
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

    public function processProductSetIsActive(int $productId, bool $value)
    {
        if ($this->productsService->loadIsActiveFunction($productId, $value)) {
            $this->systemLogsService->loadInsertSystemLogs('ProductsModel has been enabled with id: ' . $productId, $this->systemLogsService::successCode, $this->getAdminId());

            $msg = $value ? 'SuccessProductsActive' : 'ProductsIsNowDeactivated';

            return Redirect::to('products')->with('message_success', $this->getMessage('messages.' . $msg));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ProductsIsActived'));
        }
    }
}
