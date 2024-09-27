<?php

namespace App\Models;

use App\Relations\Belongs\BelongsToEmployee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TasksModel extends Model
{
    use SoftDeletes, BelongsToEmployee;

    protected $fillable = ['name', 'employee_id', 'duration', 'is_active', 'completed', 'admin_id'];

    protected $table = 'tasks';
    protected $dates = ['deleted_at'];
}
