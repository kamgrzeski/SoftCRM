<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sales extends Model
{
    /**
     * @return int
     */
    public static function countSales()
    {
        //TODO: create migrate for sales table
        //return count(DB::table('sales')->get());
    }
}
