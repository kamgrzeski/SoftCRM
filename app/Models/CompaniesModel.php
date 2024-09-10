<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompaniesModel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'tax_number',
        'phone',
        'city',
        'billing_address',
        'country',
        'postal_code',
        'employees_size',
        'fax',
        'description',
        'client_id',
        'created_at',
        'is_active',
        'admin_id'
    ];

    protected $table = 'companies';
    protected $dates = ['deleted_at'];

    public function client()
    {
        return $this->belongsTo(ClientsModel::class);
    }

    public function deals()
    {
        return $this->hasMany(DealsModel::class, 'id');
    }

    public function employees_size()
    {
        return $this->belongsTo(EmployeesModel::class);
    }

    public function finances()
    {
        return $this->hasMany(FinancesModel::class);
    }
}
