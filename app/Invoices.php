<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return Invoices::insert(
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
    public static function updateRow($id, $allInputs)
    {
        return Invoices::where('id', '=', $id)->update(
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
    public static function getRules($rulesType)
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
    public static function setActive($id, $activeType)
    {
        $findInvoicesById = Invoices::where('id', '=', $id)->update(
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
        return count(Invoices::get());
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function trySearchInvoicesByValue($type, $value, $paginationLimit = 10)
    {
        return Invoices::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->belongsTo(Companies::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
