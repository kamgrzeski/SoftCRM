<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    /**
     * @return int
     */
    public static function countProducts()
    {
//        return count(Products::get());
    }
}
