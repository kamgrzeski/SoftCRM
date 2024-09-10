<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeesModel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'company_id',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $table = 'employees';
    protected $dates = ['deleted_at'];

    public function companies()
    {
        return $this->hasMany(CompaniesModel::class);
    }

    public function deals()
    {
        return $this->belongsTo(DealsModel::class);
    }

    public function client()
    {
        return $this->belongsTo(ClientsModel::class);
    }

    public function tasks()
    {
        return $this->hasMany(TasksModel::class, 'employee_id');
    }
}

