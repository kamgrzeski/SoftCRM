<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class InvoicesModel extends Model
{
    /**
     * table name
     */
    protected $table = 'invoices';

    /**
     * @param $allInputs
     * @return mixed
     */
    public function insertRow($allInputs)
    {
        return InvoicesModel::insertGetId(
            [
                'name' => $allInputs['name'],
                'items' => $allInputs['items'],
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

    /**
     * @param $id
     * @param $allInputs
     * @return mixed
     */
    public function updateRow($id, $allInputs)
    {
        return InvoicesModel::where('id', '=', $id)->update(
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

    /**
     * @param $rulesType
     * @return array
     */
    public function getRules($rulesType)
    {
        switch ($rulesType) {
            case 'STORE':
                return [
                    'name' => 'required',
                    'cost' => 'required',
                    'companies_id' => 'required',
                    'client_id' => 'required',
                    'notes' => 'required',
                    'amount' => 'required'
                ];
        }
    }

    /**
     * @param $id
     * @param $activeType
     * @return bool
     */
    public function setActive($id, $activeType)
    {
        $findInvoicesById = InvoicesModel::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findInvoicesById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return int
     */
    public static function countInvoices()
    {
        return InvoicesModel::all()->count();
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function trySearchInvoicesByValue($type, $value, $paginationLimit = 10)
    {
        return InvoicesModel::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companies()
    {
        return $this->belongsTo(CompaniesModel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(ClientsModel::class);
    }

    public static function countRows()
    {
        return InvoicesModel::all()->count();
    }
}
