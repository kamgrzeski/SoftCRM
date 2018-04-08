<?php

namespace App\Models;

use App\Services\FinancesService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FinancesModel extends Model
{

    /**
     * table name
     */
    protected $table = 'finances';

    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        $financesHelper = new FinancesService();
        $dataToInsert = $financesHelper->calculateNetAndVatByGivenGross($allInputs['gross']);

        return FinancesModel::insertGetId(
            [
                'name' => $allInputs['name'],
                'description' => $allInputs['description'],
                'category' => $allInputs['category'],
                'type' => $allInputs['type'],
                'gross' => $allInputs['gross'],
                'net' => $dataToInsert['net'],
                'vat' => $dataToInsert['vat'],
                'date' => $allInputs['date'],
                'companies_id' => $allInputs['companies_id'],
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
        $financesHelper = new FinancesService();
        $dataToInsert = $financesHelper->calculateNetAndVatByGivenGross($allInputs['gross']);

        return FinancesModel::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'description' => $allInputs['description'],
                'type' => $allInputs['type'],
                'category' => $allInputs['category'],
                'gross' => $allInputs['gross'],
                'net' => $dataToInsert['net'],
                'vat' => $dataToInsert['vat'],
                'date' => $allInputs['date'],
                'companies_id' => $allInputs['companies_id'],
                'updated_at' => Carbon::now(),
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
                    'companies_id' => 'required',
                    'description' => 'required',
                    'type' => 'required',
                    'gross' => 'required',
                    'category' => 'required'
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
        $findFinancesById = FinancesModel::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findFinancesById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return int
     */
    public static function countFinances()
    {
        return count(FinancesModel::get());
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function trySearchFinancesByValue($type, $value, $paginationLimit = 10)
    {
        return FinancesModel::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->belongsTo(CompaniesModel::class);
    }
}
