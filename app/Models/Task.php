<?php

namespace App\Models;

use App\Relations\Belongs\BelongsToEmployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes, BelongsToEmployee;

    protected $fillable = ['name', 'employee_id', 'duration', 'is_active', 'completed', 'admin_id'];
}
