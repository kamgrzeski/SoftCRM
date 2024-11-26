<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealTerm extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['body', 'deal_id'];
}
