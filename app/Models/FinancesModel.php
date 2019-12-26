<?php

namespace App\Models;

use App\Services\FinancesService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Config;

class FinancesModel extends Model
{
    protected $table = 'finances';

    public function companies()
    {
        return $this->belongsTo(CompaniesModel::class);
    }

    public function storeFinance($requestedData)
    {
        $financesHelper = new FinancesService();
        $dataToInsert = $financesHelper->calculateNetAndVatByGivenGross($requestedData['gross']);

        return self::insertGetId(
            [
                'name' => $requestedData['name'],
                'description' => $requestedData['description'],
                'category' => $requestedData['category'],
                'type' => $requestedData['type'],
                'gross' => $requestedData['gross'],
                'net' => $dataToInsert['net'],
                'vat' => $dataToInsert['vat'],
                'date' => $requestedData['date'] ?? Carbon::now(),
                'companies_id' => $requestedData['companies_id'],
                'created_at' => Carbon::now(),
                'is_active' => 1
            ]
        );
    }

    public function updateFinance($financeId, $requestedData)
    {
        $financesHelper = new FinancesService();
        $dataToInsert = $financesHelper->calculateNetAndVatByGivenGross($requestedData['gross']);

        return self::where('id', '=', $financeId)->update(
            [
                'name' => $requestedData['name'],
                'description' => $requestedData['description'],
                'type' => $requestedData['type'],
                'category' => $requestedData['category'],
                'gross' => $requestedData['gross'],
                'net' => $dataToInsert['net'],
                'vat' => $dataToInsert['vat'],
                'date' => $requestedData['date'],
                'companies_id' => $requestedData['companies_id'],
                'updated_at' => Carbon::now(),
                'is_active' => 1
            ]);
    }

    public function setActive($financeId, $activeType)
    {
        $findFinancesById = self::where('id', '=', $financeId)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findFinancesById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function countFinances()
    {
        return self::get()->count();
    }

    public function getPluckCompanies()
    {
        return CompaniesModel::pluck('name', 'id');
    }

    public function getFinancesSortedByCreatedAt()
    {
        return self::all()->sortByDesc('created_at');
    }

    public function getPaginate()
    {
        return self::paginate(Config::get('crm_settings.pagination_size'));
    }
}
