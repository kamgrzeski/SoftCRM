<?php

namespace App\Models;

use App\Relations\Belongs\BelongsToProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesModel extends Model
{
    use SoftDeletes, BelongsToProduct;

    protected $fillable = ['name', 'quantity', 'date_of_payment', 'product_id', 'price', 'is_active', 'admin_id'];

    protected $casts = [
        'date_of_payment' => 'datetime'
    ];

    protected $table = 'sales';
    protected $dates = ['deleted_at'];
}
