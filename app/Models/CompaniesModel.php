<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Config;

class CompaniesModel extends Model
{
    protected $table = 'companies';

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

    public function insertCompanie(array $requestedData, int $adminId) : int
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
                'created_at' => Carbon::now(),
                'is_active' => 1,
                'admin_id' => $adminId
            ]
        );
    }

    public function updateCompanie(int $companiesId, array $requestedData) : bool
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
                'is_active' => 1
            ]);
    }

    public function setActive(int $companiesId, int $activeType) : bool
    {
       return $this->where('id', '=', $companiesId)->update(['is_active' => $activeType]);
    }

    public function countCompanies() : int
    {
        return $this->all()->count();
    }

    public function getCompaniesInLatestMonth() : float
    {
        $companiesCount = self::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $allCompanies = self::all()->count();

        $percentage = ($allCompanies / 100) * $companiesCount;

        return $percentage;
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
}
