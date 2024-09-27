<?php

namespace App\Relations\Belongs;

use App\Models\ProductsModel;

trait BelongsToProduct
{
    /**
     * Belongs to product.
     */
    public function product()
    {
        return $this->belongsTo(ProductsModel::class, 'product_id');
    }
}
