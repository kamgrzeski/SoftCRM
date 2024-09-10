<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TasksModel extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'employee_id', 'duration', 'is_active', 'completed', 'admin_id'];

    protected $table = 'tasks';
    protected $dates = ['deleted_at'];

    public function employees()
    {
        return $this->belongsTo(EmployeesModel::class, 'employee_id');
    }
}
