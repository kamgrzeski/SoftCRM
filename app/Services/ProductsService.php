<?php

namespace App\Services;

use App\Models\ProductsModel;

class ProductsService
{
    private $productsModel;

    public function __construct()
    {
        $this->productsModel = new ProductsModel();
    }

    public function getProducts()
    {
        return ProductsModel::all()->sortByDesc('created_at');
    }

    public function getPagination()
    {
        return ProductsModel::paginate(Config::get('crm_settings.pagination_size'));
    }

    public function execute($allInputs)
    {
        return $this->productsModel->insertRow($allInputs);
    }

    public function getProduct(int $id)
    {
        return ProductsModel::find($id);
    }

    public function update(int $id, $allInputs)
    {
        return $this->productsModel->updateRow($id, $allInputs);
    }

    public function loadIsActiveFunction($id, $value)
    {
        return $this->productsModel->setActive($id, $value);
    }

    public function loadSearch($getValueInput)
    {
        return count($this->productsModel->trySearchProductsByValue('full_name', $getValueInput, 10));
    }

    public function loadProductsByCreatedAt()
    {
        return $this->productsModel->getProductsByCreatedAt();
    }
}