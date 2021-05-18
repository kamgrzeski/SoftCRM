<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class CompaniesModel extends Model
{
    use SoftDeletes;

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

    public function storeCompany(array $requestedData, int $adminId) : int
    {
        return $this->insertGetId(
            [
                'name' => $requestedData['name'],
                'tax_number' => $requestedData['tax_number'],
                'phone' => $requestedData['phone'],
                'city' => $requestedData['city'],
                'billing_address' => $requestedData['billing_address'],
                'country' => $requestedData['country'],
                'postal_code' => $requestedData['postal_code'],
                'employees_size' => $requestedData['employees_size'],
                'fax' => $requestedData['fax'],
                'description' => $requestedData['description'],
                'client_id' => $requestedData['client_id'],
                'created_at' => now(),
                'is_active' => true,
                'admin_id' => $adminId
            ]
        );
    }

    public function updateCompany(int $companiesId, array $requestedData) : int
    {
        return $this->where('id', '=', $companiesId)->update(
            [
                'name' => $requestedData['name'],
                'tax_number' => $requestedData['tax_number'],
                'phone' => $requestedData['phone'],
                'city' => $requestedData['city'],
                'billing_address' => $requestedData['billing_address'],
                'country' => $requestedData['country'],
                'postal_code' => $requestedData['postal_code'],
                'employees_size' => $requestedData['employees_size'],
                'fax' => $requestedData['fax'],
                'description' => $requestedData['description'],
                'client_id' => $requestedData['client_id'],
                'is_active' => true,
                'updated_at' => now()
            ]);
    }

    public function setActive(int $companiesId, int $activeType) : int
    {
       return $this->where('id', '=', $companiesId)->update(
           [
               'is_active' => $activeType
           ]
       );
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
        return $this->paginate(Config::get('crm_settings.pagination_size'));
    }

    public function getCompany(int $companyId)
    {
        return $this::find($companyId);
    }

    public function pluckData()
    {
        return $this->pluck('name', 'id');
    }

    public function getAll()
    {
        return $this->all()->sortBy('created_at');
    }
}
