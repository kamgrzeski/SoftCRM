<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsModel extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    public function getCountProducts()
    {
        return $this->all()->count();
    }

    public function getProducts()
    {
        return $this->all()->slice(0, 5);
    }
}