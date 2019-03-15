<?php

namespace App\Models;

use App\Services\FinancesService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FinancesModel extends Model
{
    protected $table = 'finances';

    public function companies()
    {
        return $this->belongsTo(CompaniesModel::class);
    }

    public function insertRow($allInputs)
    {
        $financesHelper = new FinancesService();
        $dataToInsert = $financesHelper->calculateNetAndVatByGivenGross($allInputs['gross']);

        return self::insertGetId(
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

    public function updateRow($id, $allInputs)
    {
        $financesHelper = new FinancesService();
        $dataToInsert = $financesHelper->calculateNetAndVatByGivenGross($allInputs['gross']);

        return self::where('id', '=', $id)->update(
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

    public function setActive($id, $activeType)
    {
        $findFinancesById = self::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findFinancesById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function countFinances()
    {
        return count(self::get());
    }
}
