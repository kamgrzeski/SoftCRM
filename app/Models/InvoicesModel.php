<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class InvoicesModel extends Model
{
    protected $table = 'invoices';

    public function insertRow($allInputs)
    {
        return self::insertGetId(
            [
                'name' => $allInputs['name'],
                'cost' => $allInputs['cost'],
                'companies_id' => $allInputs['companies_id'],
                'client_id' => $allInputs['client_id'],
                'notes' => $allInputs['notes'],
                'amount' => $allInputs['amount'],
                'created_at' => Carbon::now(),
                'is_active' => 1
            ]
        );
    }

    public function updateRow($id, $allInputs)
    {
        return self::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'cost' => $allInputs['cost'],
                'companies_id' => $allInputs['companies_id'],
                'client_id' => $allInputs['client_id'],
                'notes' => $allInputs['notes'],
                'amount' => $allInputs['amount'],
                'updated_at' => Carbon::now(),
                'is_active' => 1
            ]);
    }

    public function setActive($id, $activeType)
    {
        $findInvoicesById = self::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findInvoicesById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function countInvoices()
    {
        return self::all()->count();
    }

    public function companies()
    {
        return $this->belongsTo(CompaniesModel::class);
    }

    public function client()
    {
        return $this->belongsTo(ClientsModel::class);
    }

    public static function countRows()
    {
        return self::all()->count();
    }
}
