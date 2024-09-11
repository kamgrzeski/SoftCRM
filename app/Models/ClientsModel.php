<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientsModel extends Model
{
    use SoftDeletes;

    protected $table = 'clients';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'full_name', 'phone', 'email', 'section', 'budget', 'location', 'zip', 'city', 'country', 'is_active', 'admin_id'
    ];

    public function companies()
    {
        return $this->hasMany(CompaniesModel::class, 'client_id');
    }

    public function employees()
    {
        return $this->hasMany(EmployeesModel::class, 'id');
    }
}
