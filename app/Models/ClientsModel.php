<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientsModel extends Model
{
    use SoftDeletes;

    protected $table = 'clients';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'full_name', 'phone', 'email', 'section', 'budget', 'location', 'zip', 'city', 'country', 'is_active', 'admin_id'
    ];

    public function companies()
    {
        return $this->hasMany(CompaniesModel::class, 'id');
    }

    public function employees()
    {
        return $this->hasMany(EmployeesModel::class, 'id');
    }

    public function countClients(): int
    {
        return $this->all()->count();
    }

    public static function getClientsInLatestMonth() : float
    {
        $clientCount = self::where('created_at', '>=', now()->subMonth())->count();
        $allClient = self::all()->count();

        return ($allClient / 100) * $clientCount;
    }

    public function getDeactivated(): int
    {
        return $this->where('is_active', '=', 0)->count();
    }

    public function getClientByGivenClientId(int $clientId) : self
    {
        return $this->find($clientId);
    }

    public function getClientSortedBy()
    {
        return $this->all()->sortBy('created_at');
    }

    public function getPaginate()
    {
        return $this->orderByDesc('id')->paginate(SettingsModel::where('key', 'pagination_size')->get()->last()->value);
    }
}
