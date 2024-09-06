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

    public function countCompanies() : int
    {
        return $this->all()->count();
    }

    public function getCompaniesInLatestMonth() : float
    {
        $companiesCount = $this->where('created_at', '>=', now()->subMonth())->count();
        $allCompanies = $this->all()->count();

        return ($allCompanies / 100) * $companiesCount;
    }

    public function getDeactivated() : int
    {
        return $this->where('is_active', '=', 0)->count();
    }

    public function getCompaniesSortedByCreatedAt()
    {
        return $this->all()->sortBy('created_at', 0, true)->slice(0, 5);
    }

    public function getPaginate()
    {
        return $this->orderByDesc('id')->paginate(SettingsModel::where('key', 'pagination_size')->get()->last()->value);
    }

    public function pluckData()
    {
        return $this->pluck('name', 'id');
    }

    public function getAll(bool $createForm = false)
    {
        if($createForm) {
            return $this->pluck('name', 'id');
        }

        return $this->all()->sortBy('created_at');
    }
}
