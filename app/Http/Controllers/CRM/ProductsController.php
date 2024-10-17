<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Jobs\Product\StoreProductJob;
use App\Jobs\Product\UpdateProductJob;
use App\Jobs\StoreSystemLogJob;
use App\Models\ProductsModel;
use App\Queries\ProductsQueries;
use App\Services\ProductsService;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class ProductsController
 *
 * Controller for handling product-related operations in the CRM.
 */
class ProductsController extends Controller
{
    use DispatchesJobs;
    private ProductsService $productsService;

    /**
     * ProductsController constructor.
     *
     * @param ProductsService $productsService
     */
    public function __construct(ProductsService $productsService)
    {
        $this->middleware(self::MIDDLEWARE_AUTH);

        $this->productsService = $productsService;
    }

    /**
     * Render the form for creating a new product record.
     *
     * @return \Illuminate\View\View
     */
    public function processRenderCreateForm(): \Illuminate\View\View
    {
        // Render the create form.
        return view('crm.products.create');
    }

    /**
     * Show the details of a specific product record.
     *
     * @param ProductsModel $product
     * @return \Illuminate\View\View
     */
    public function processShowProductsDetails(ProductsModel $product): \Illuminate\View\View
    {
        // Load the product details and render the show page.
        return view('crm.products.show')->with(['product' => $product]);
    }

    /**
     * Render the form for updating an existing product record.
     *
     * @param ProductsModel $product
     * @return \Illuminate\View\View
     */
    public function processRenderUpdateForm(ProductsModel $product): \Illuminate\View\View
    {
        // Load the product details and render the update form.
        return view('crm.products.update')->with(['product' => $product]);
    }

    /**
     * List all product records with pagination.
     *
     * @return \Illuminate\View\View
     */
    public function processListOfProducts(): \Illuminate\View\View
    {
        // Load the products with pagination.
        return view('crm.products.index')->with([
            'products' => ProductsQueries::getPaginate()
        ]);
    }

    /**
     * Store a new product record.
     *
     * @param ProductStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processStoreProduct(ProductStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        // Store the product.
        $this->dispatchSync(new StoreProductJob($request->validated(), auth()->user()));

        // Store a system log.
        $this->dispatchSync(new StoreSystemLogJob('Product has been added.', 201, auth()->user()));

        // Redirect to the products page with a success message.
        return redirect()->to('products')->with('message_success', $this->getMessage('messages.product_store'));
    }

    /**
     * Update an existing product record.
     *
     * @param ProductUpdateRequest $request
     * @param ProductsModel $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processUpdateProduct(ProductUpdateRequest $request, ProductsModel $product): \Illuminate\Http\RedirectResponse
    {
        // Update the product.
        $this->dispatchSync(new UpdateProductJob($request->validated(), $product));

        // Store a system log.
        return redirect()->to('products')->with('message_success', $this->getMessage('messages.product_store'));
    }

    /**
     * Delete a product record.
     *
     * @param ProductsModel $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processDeleteProduct(ProductsModel $product): \Illuminate\Http\RedirectResponse
    {
        // Check if the product has any sales records.
        if ($product->sales()->count() > 0) {
            return redirect()->back()->with('message_error', $this->getMessage('messages.product_first_delete_sales'));
        }

        // Delete the product.
        $product->delete();

        // Store a system log.
        $this->dispatchSync(new StoreSystemLogJob('ProductsModel has been deleted with id: ' . $product->id, 201, auth()->user()));

        // Redirect to the products page with a success message.
        return redirect()->to('products')->with('message_success', $this->getMessage('messages.product_delete'));
    }

    /**
     * Set the active status of a product record.
     *
     * @param ProductsModel $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processProductSetIsActive(ProductsModel $product): \Illuminate\Http\RedirectResponse
    {
        // Update the product's active status.
        $this->dispatchSync(new UpdateProductJob(['is_active' => $product->is_active], $product));

        // Store a system log.
        $this->dispatchSync(new StoreSystemLogJob('ProductsModel has been enabled with id: ' . $product->id, 201, auth()->user()));

        // Redirect to the products page with a success message.
        return redirect()->to('products')->with('message_success', $this->getMessage('messages.product_update'));
    }
}
