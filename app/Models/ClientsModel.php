<?php

namespace App\Models;

use Carbon\Carbon;
use ClickNow\Money\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Config;

class ClientsModel extends Model
{
    protected $table = 'clients';

    public function companies()
    {
        return $this->hasMany(CompaniesModel::class, 'id');
    }

    public function employees()
    {
        return $this->hasMany(EmployeesModel::class, 'id');
    }

    public function storeClient($requestedData)
    {
        return self::insertGetId(
            [
                'full_name' => $requestedData['full_name'],
                'phone' => $requestedData['phone'],
                'email' => $requestedData['email'],
                'section' => $requestedData['section'],
                'budget' => $requestedData['budget'],
                'location' => $requestedData['location'],
                'zip' => $requestedData['zip'],
                'city' => $requestedData['city'],
                'country' => $requestedData['country'],
                'created_at' => Carbon::now(),
                'is_active' => 1
            ]
        );
    }

    public function updateClient($id, $requestedData)
    {
        return self::where('id', '=', $id)->update(
            [
                'full_name' => $requestedData['full_name'],
                'phone' => $requestedData['phone'],
                'email' => $requestedData['email'],
                'section' => $requestedData['section'],
                'budget' => $requestedData['budget'],
                'location' => $requestedData['location'],
                'zip' => $requestedData['zip'],
                'city' => $requestedData['city'],
                'country' => $requestedData['country'],
                'updated_at' => Carbon::now(),
                'is_active' => 1
            ]);
    }

    public function setClientActive($id, $activeType)
    {
        $findClientById = self::where('id', '=', $id)->update(['is_active' => $activeType]);

        if ($findClientById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function countClients()
    {
        return self::all()->count();
    }

    public static function getClientsInLatestMonth() {
        $clientCount = self::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $allClient = self::all()->count();

        $new_width = ($allClient / 100) * $clientCount;

        return $new_width;
    }

    public function getDeactivated()
    {
        return self::where('is_active', '=', 0)->count();
    }

    public function findClientByGivenClientId($clientId)
    {
        $query = self::find($clientId);

        Arr::add($query, 'companiesCount', count($query->companies));
        Arr::add($query, 'employeesCount', count($query->employees));
        Arr::add($query, 'formattedBudget', Money::{config('crm_settings.currency')}($query->budget));

        return $query;
    }

    public function getClientSortedBy($by)
    {
        $query = self::all()->sortByDesc($by);

        foreach($query as $key => $client) {
            $query[$key]->budget = Money::{config('crm_settings.currency')}($client->budget);
        }

        return $query;
    }

    public function getPaginate()
    {
        return self::paginate(Config::get('crm_settings.pagination_size'));
    }
}
