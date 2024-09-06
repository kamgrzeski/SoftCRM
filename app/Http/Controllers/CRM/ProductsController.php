<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Jobs\Product\StoreProductJob;
use App\Jobs\Product\UpdateProductJob;
use App\Jobs\StoreSystemLogJob;
use App\Models\ProductsModel;
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

    public function processShowProductsDetails(ProductsModel $product)
    {
        return view('crm.products.show')->with(['product' => $product]);
    }

    public function processRenderUpdateForm(ProductsModel $product)
    {
        return view('crm.products.edit')->with(['product' => $product]);
    }

    public function processListOfProducts()
    {
        return view('crm.products.index')->with([
            'productsPaginate' => $this->productsService->loadPagination()
        ]);
    }

    public function processStoreProduct(ProductStoreRequest $request)
    {
        $this->dispatchSync(new StoreProductJob($request->validated(), auth()->user()));

        $this->dispatchSync(new StoreSystemLogJob('Product has been added.', $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('products')->with('message_success', $this->getMessage('messages.SuccessProductsStore'));
    }

    public function processUpdateProduct(ProductUpdateRequest $request, ProductsModel $product)
    {
        $this->dispatchSync(new UpdateProductJob($request->validated(), $product));

        return redirect()->to('products')->with('message_success', $this->getMessage('messages.SuccessProductsStore'));
    }

    public function processDeleteProduct(ProductsModel $product)
    {
        if ($product->sales()->count() > 0) {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.ProductsCannotBeDeleted'));
        }

        // Delete the product.
        $product->delete();

        $this->dispatchSync(new StoreSystemLogJob('ProductsModel has been deleted with id: ' . $product->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('products')->with('message_success', $this->getMessage('messages.SuccessProductsDelete'));
    }

    public function processProductSetIsActive(ProductsModel $product, bool $value)
    {
        $this->dispatchSync(new UpdateProductJob(['is_active' => $value], $product));

        $this->dispatchSync(new StoreSystemLogJob('ProductsModel has been enabled with id: ' . $product->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('products')->with('message_success', $this->getMessage('messages.' . $value ? 'SuccessProductsActive' : 'ProductsIsNowDeactivated'));
    }
}
