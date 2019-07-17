<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesModel extends Model
{
    use SoftDeletes;

    protected $table = 'sales';

    public function getCountSales()
    {
        return $this->all()->count();
    }
}