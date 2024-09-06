<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Jobs\StoreSystemLogJob;
use App\Services\ProductsService;
use App\Services\SystemLogService;
use Illuminate\Foundation\Bus\DispatchesJobs;

class ProductsController extends Controller
{
    use DispatchesJobs;
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
        return view('crm.products.create');
    }

    public function processShowProductsDetails(int $productId)
    {
        return view('crm.products.show')->with(['product' => $this->productsService->loadProduct($productId)]);
    }

    public function processRenderUpdateForm(int $productId)
    {
        return view('crm.products.edit')->with(['product' => $this->productsService->loadProduct($productId)]);
    }

    public function processListOfProducts()
    {
        return view('crm.products.index')->with(
            [
                'productsPaginate' => $this->productsService->loadPagination()
            ]
        );
    }

    public function processStoreProduct(ProductStoreRequest $request)
    {
        $storedProductId = $this->productsService->execute($request->validated(), $this->getAdminId());

        if ($storedProductId) {
            $this->dispatchSync(new StoreSystemLogJob('Product has been add with id: ' . $storedProductId, $this->systemLogsService::successCode, auth()->user()));
            return redirect()->to('products')->with('message_success', $this->getMessage('messages.SuccessProductsStore'));
        } else {
            return redirect()->back()->with('message_success', $this->getMessage('messages.ErrorProductsStore'));
        }
    }

    public function processUpdateProduct(ProductUpdateRequest $request, int $productId)
    {
        if ($this->productsService->update($productId, $request->validated())) {
            return redirect()->to('products')->with('message_success', $this->getMessage('messages.SuccessProductsStore'));
        } else {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.ErrorProductsStore'));
        }
    }

    public function processDeleteProduct(int $productId)
    {
        $clientAssigned = $this->productsService->checkIfProductHaveAssignedSale($productId);

        if (!empty($clientAssigned)) {
            return redirect()->back()->with('message_danger', $clientAssigned);
        } else {
            $productsDetails = $this->productsService->loadProduct($productId);
            $productsDetails->delete();
        }

        $this->dispatchSync(new StoreSystemLogJob('ProductsModel has been deleted with id: ' . $productsDetails->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('products')->with('message_success', $this->getMessage('messages.SuccessProductsDelete'));
    }

    public function processProductSetIsActive(int $productId, bool $value)
    {
        if ($this->productsService->loadIsActiveFunction($productId, $value)) {
            $this->dispatchSync(new StoreSystemLogJob('ProductsModel has been enabled with id: ' . $productId, $this->systemLogsService::successCode, auth()->user()));

            $msg = $value ? 'SuccessProductsActive' : 'ProductsIsNowDeactivated';

            return redirect()->to('products')->with('message_success', $this->getMessage('messages.' . $msg));
        } else {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.ProductsIsActived'));
        }
    }
}
