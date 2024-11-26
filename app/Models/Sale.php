<?php

namespace App\Models;

use App\Relations\Belongs\BelongsToProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes, BelongsToProduct;

    protected $fillable = ['name', 'quantity', 'price', 'date_of_payment', 'product_id', 'is_active', 'admin_id'];

    protected $casts = [
        'date_of_payment' => 'datetime'
    ];
}
