<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsStoreRequest;
use App\Models\ProductsModel;
use App\Services\ProductsService;
use App\Services\SystemLogService;
use App\Traits\Language;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class ProductsController extends Controller
{
    use Language;

    private $systemLogs;
    private $language;
    private $productsModel;
    private $productsService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->productsModel = new ProductsModel();
        $this->productsService = new ProductsService();
    }

    private function getDataAndPagination()
    {
        $dataWithProducts = [
            'products' => $this->productsService->getProducts(),
            'productsPaginate' => $this->productsService->getPagination()
        ];

        return $dataWithProducts;
    }

    public function index()
    {
        return View::make('crm.products.index')->with($this->getDataAndPagination());
    }

    public function create()
    {
        return View::make('crm.products.create')->with([
            'inputText' => $this->getMessage('messages.InputText')
        ]);
    }
    
    public function show($productId)
    {
        return View::make('crm.products.show')
            ->with([
                'products' => $this->productsService->getProduct($productId),
            ]);
    }

    public function edit($productId)
    {
        return View::make('crm.products.edit')
            ->with('products', $this->productsService->getProduct($productId));
    }
    
    public function store(ProductsStoreRequest $request)
    {
        if ($product = $this->productsService->execute($request->validated())) {
            $this->systemLogs->insertSystemLogs('Product has been add with id: '. $product, $this->systemLogs::successCode);
            return Redirect::to('products')->with('message_success', $this->getMessage('messages.SuccessProductsStore'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorProductsStore'));
        }
    }

    public function update(Request $request, int $productId)
    {
        if ($this->productsService->update($productId, $request->all())) {
            return Redirect::to('products')->with('message_success', $this->getMessage('messages.SuccessProductsStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorProductsStore'));
        }
    }

    public function destroy($productId)
    {
        $productsDetails = $this->productsService->getProduct($productId);
        $productsDetails->delete();

        $this->systemLogs->insertSystemLogs('ProductsModel has been deleted with id: ' . $productsDetails->id, $this->systemLogs::successCode);


        return Redirect::to('products')->with('message_success', $this->getMessage('messages.SuccessProductsDelete'));
    }

    public function isActiveFunction($productId, $value)
    {
        if ($this->productsService->loadIsActiveFunction($productId, $value)) {
            $this->systemLogs->insertSystemLogs('ProductsModel has been enabled with id: ' . $productId, $this->systemLogs::successCode);
            return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessProductsActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ProductsIsActived'));
        }
    }

    public function search()
    {
        return true; // TODO
    }
}
