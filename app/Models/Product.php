<?php

namespace App\Models;

use App\Relations\Has\HasManySales;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasManySales;

    protected $fillable = ['name', 'category', 'count', 'price', 'is_active', 'admin_id'];
}
