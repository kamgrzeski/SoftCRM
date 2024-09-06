<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealsTermsModel extends Model
{
    use SoftDeletes;

    protected $table = 'deals_terms';
    protected $dates = ['deleted_at'];
}
