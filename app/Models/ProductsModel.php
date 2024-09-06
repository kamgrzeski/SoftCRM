<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsModel extends Model
{
    use SoftDeletes;

    protected $table = 'products';
    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'category', 'count', 'price', 'is_active', 'admin_id'];

    public function sales()
    {
        return $this->hasMany(SalesModel::class, 'id');
    }

    public function countProducts(): int
    {
        return $this->get()->count();
    }

    public function getProductsByCreatedAt()
    {
        return $this->all()->sortBy('created_at', 0, true)->slice(0, 5);
    }

    public function getProducts()
    {
        return $this->all()->sortBy('created_at');
    }

    public function getPaginate()
    {
        return $this->orderByDesc('id')->paginate(SettingsModel::where('key', 'pagination_size')->get()->last()->value);
    }
}
