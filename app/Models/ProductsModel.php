<?php

namespace App\Models;

use App\Relations\Has\HasManySales;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsModel extends Model
{
    use SoftDeletes, HasManySales;

    protected $table = 'products';
    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'category', 'count', 'price', 'is_active', 'admin_id'];
}
