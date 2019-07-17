<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancesModel extends Model
{
    use SoftDeletes;

    protected $table = 'finances';

    public function getCountFinances()
    {
        return $this->all()->count();
    }
}