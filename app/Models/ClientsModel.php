<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ClientsModel extends Model
{
    /**
     * table name
     */
    protected $table = 'clients';

    /**
     * @param $allInputs
     * @return mixed
     */
    public function insertRow($allInputs)
    {
        return ClientsModel::insertGetId(
            [
                'full_name' => $allInputs['full_name'],
                'phone' => $allInputs['phone'],
                'email' => $allInputs['email'],
                'section' => $allInputs['section'],
                'budget' => $allInputs['budget'],
                'location' => $allInputs['location'],
                'zip' => $allInputs['zip'],
                'city' => $allInputs['city'],
                'country' => $allInputs['country'],
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
        return ClientsModel::where('id', '=', $id)->update(
            [
                'full_name' => $allInputs['full_name'],
                'phone' => $allInputs['phone'],
                'email' => $allInputs['email'],
                'section' => $allInputs['section'],
                'budget' => $allInputs['budget'],
                'location' => $allInputs['location'],
                'zip' => $allInputs['zip'],
                'city' => $allInputs['city'],
                'country' => $allInputs['country'],
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
                    'full_name' => 'required|string',
                    'phone' => 'required',
                    'budget' => 'required',
                    'section' => 'required',
                    'email' => 'required|email',
                    'location' => 'required',
                    'zip' => 'required',
                    'city' => 'required',
                    'country' => 'required'
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
        $findClientById = ClientsModel::where('id', '=', $id)->update(['is_active' => $activeType]);

        if ($findClientById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function trySearchClientByValue($type, $value, $paginationLimit = 10)
    {
        return ClientsModel::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    /**
     * @return int
     */
    public static function countClients()
    {
        return ClientsModel::all()->count();
    }

    /**
     * @return float|int
     */
    public static function getClientsInLatestMonth() {
        $clientCount = ClientsModel::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $allClient = ClientsModel::all()->count();

        $new_width = ($allClient / 100) * $clientCount;

        return $new_width;
    }

    /**
     * @return mixed
     */
    public static function getDeactivated()
    {
        return ClientsModel::where('is_active', '=', 0)->count();
    }

    /**
     * @param $clientId
     * @return mixed
     */
    public function findClientByGivenClientId($clientId)
    {
        return ClientsModel::find($clientId);
    }

    /**
     * @param $by
     * @return ClientsModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getClientSortedBy($by)
    {
        return ClientsModel::all()->sortByDesc($by);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany(CompaniesModel::class, 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees()
    {
        return $this->hasMany(EmployeesModel::class, 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany(InvoicesModel::class, 'client_id');
    }
}
