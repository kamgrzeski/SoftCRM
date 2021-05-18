<?php

namespace App\Models;

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Config;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ClientsModel extends Model
{
    use SoftDeletes;

    protected $table = 'clients';
    protected $dates = ['deleted_at'];

    public function companies()
    {
        return $this->hasMany(CompaniesModel::class, 'id');
    }

    public function employees()
    {
        return $this->hasMany(EmployeesModel::class, 'id');
    }

    public function storeClient(array $requestedData, int $adminId) : int
    {
        return $this->insertGetId(
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
                'created_at' => now(),
                'is_active' => true,
                'admin_id' => $adminId
            ]
        );
    }

    public function updateClient(int $id, array $requestedData) : int
    {
        return $this->where('id', '=', $id)->update(
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
                'updated_at' => now()
            ]
        );
    }

    public function setClientActive(int $id, int $activeType) : int
    {
        return $this->where('id', '=', $id)->update(
            [
                'is_active' => $activeType,
                'updated_at' => now()
            ]
        );
    }

    public function countClients() : int
    {
        return $this->all()->count();
    }

    public static function getClientsInLatestMonth() : float
    {
        $clientCount = self::where('created_at', '>=', now()->subMonth())->count();
        $allClient = self::all()->count();

        return ($allClient / 100) * $clientCount;
    }

    public function getDeactivated() : int
    {
        return $this->where('is_active', '=', 0)->count();
    }

    public function getClientByGivenClientId(int $clientId) : self
    {
        $query = $this->find($clientId);

        if(is_null($query)) {
            throw new BadRequestHttpException('User with given clientId not exists.');
        }

        Arr::add($query, 'companiesCount', count($query->companies));
        Arr::add($query, 'employeesCount', count($query->employees));
        Arr::add($query, 'formattedBudget', Money::{SettingsModel::getSettingValue('currency')}($query->budget));

        return $query;
    }

    public function getClientSortedBy()
    {
        $query = $this->all()->sortBy('created_at');

        foreach($query as $key => $client) {
            $query[$key]->budget = Money::{SettingsModel::getSettingValue('currency')}($client->budget);
        }

        return $query;
    }

    public function getPaginate()
    {
        return $this->paginate(Config::get('crm_settings.pagination_size'));
    }
}
