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

    public function insertCompanie($requestedData)
    {
        return self::insertGetId(
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
                'is_active' => 1
            ]
        );
    }

    public function updateCompanie($companieId, $requestedData)
    {
        return self::where('id', '=', $companieId)->update(
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

    public function setActive($companieId, $activeType)
    {
        $findCompaniesById = self::where('id', '=', $companieId)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findCompaniesById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function countCompanies()
    {
        return self::all()->count();
    }

    public function getCompaniesInLatestMonth() {
        $companiesCount = self::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $allCompanies = self::all()->count();

        $percentage = ($allCompanies / 100) * $companiesCount;

        return $percentage;
    }

    public function getDeactivated()
    {
        return self::where('is_active', '=', 0)->count();
    }

    public function getCompaniesSortedByCreatedAt()
    {
        return self::all()->sortBy('created_at', 0, true)->slice(0, 5);
    }

    public function getPaginate()
    {
        return self::paginate(Config::get('crm_settings.pagination_size'));
    }
}
