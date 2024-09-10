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
}
