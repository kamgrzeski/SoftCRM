<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CompaniesModel extends Model
{
    /**
     * table name
     */
    protected $table = 'companies';

    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return CompaniesModel::insertGetId(
            [
                'name' => $allInputs['name'],
                'tax_number' => $allInputs['tax_number'],
                'phone' => $allInputs['phone'],
                'city' => $allInputs['city'],
                'billing_address' => $allInputs['billing_address'],
                'country' => $allInputs['country'],
                'postal_code' => $allInputs['postal_code'],
                'employees_size' => $allInputs['employees_size'],
                'fax' => $allInputs['fax'],
                'description' => $allInputs['description'],
                'client_id' => $allInputs['client_id'],
                'created_at' => Carbon::now(),
                'is_active' => 1
            ]
        );
    }

    /**
     * @param $id
     * @param $allInputs
     * @return mixed
     */
    public static function updateRow($id, $allInputs)
    {
        return CompaniesModel::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'tax_number' => $allInputs['tax_number'],
                'phone' => $allInputs['phone'],
                'city' => $allInputs['city'],
                'billing_address' => $allInputs['billing_address'],
                'country' => $allInputs['country'],
                'postal_code' => $allInputs['postal_code'],
                'employees_size' => $allInputs['employees_size'],
                'fax' => $allInputs['fax'],
                'description' => $allInputs['description'],
                'client_id' => $allInputs['client_id'],
                'is_active' => 1
            ]);
    }

    /**
     * @param $rulesType
     * @return array
     */
    public static function getRules($rulesType)
    {
        switch ($rulesType) {
            case 'STORE':
                return [
                    'name' => 'required',
                    'tax_number' => 'required|integer',
                    'city' => 'required',
                    'billing_address' => 'required',
                    'country' => 'required',
                    'postal_code' => 'required',
                    'employees_size' => 'required|integer',
                    'fax' => 'required',
                    'description' => 'required',
                    'phone' => 'required',
                    'client_id' => 'required',
                ];
        }
    }

    /**
     * @param $id
     * @param $activeType
     * @return bool
     */
    public static function setActive($id, $activeType)
    {
        $findCompaniesById = CompaniesModel::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findCompaniesById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function trySearchCompaniesByValue($type, $value, $paginationLimit = 10)
    {
        return CompaniesModel::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    /**
     * @return int
     */
    public static function countCompanies()
    {
        return count(CompaniesModel::get());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(ClientsModel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deals()
    {
        return $this->hasMany(DealsModel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employees_size()
    {
        return $this->belongsTo(employees_size::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function finances()
    {
        return $this->hasMany(FinancesModel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany(InvoicesModel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(FilesModel::class);
    }

    /**
     * @return float|int
     */
    public static function getCompaniesInLatestMonth() {
        $companiesCount = CompaniesModel::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $allCompanies = CompaniesModel::all()->count();

        $percentage = ($allCompanies / 100) * $companiesCount;

        return $percentage;
    }

    /**
     * @return mixed
     */
    public static function getDeactivated()
    {
        return CompaniesModel::where('is_active', '=', 0)->count();
    }
}
