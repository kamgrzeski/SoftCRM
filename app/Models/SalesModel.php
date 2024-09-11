<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesModel extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'quantity', 'date_of_payment', 'product_id', 'price', 'is_active', 'admin_id'];

    protected $casts = [
        'date_of_payment' => 'datetime'
    ];

    protected $table = 'sales';
    protected $dates = ['deleted_at'];

    public function products()
    {
        return $this->belongsTo(ProductsModel::class, 'product_id');
    }
}
