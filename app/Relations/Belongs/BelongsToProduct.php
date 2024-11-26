<?php

namespace App\Relations\Belongs;

use App\Models\Product;

trait BelongsToProduct
{
    /**
     * Belongs to product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
