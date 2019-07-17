<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientsModel extends Model
{
    use SoftDeletes;

    protected $table = 'clients';

    protected $fillable = [ 'full_name', 'lang', 'date_format', 'per_page', 'dashboard_history', 'email_newsletters' ];

    public function getCountClients()
    {
        return $this->all()->count();
    }

    public function getCountOfDeactivatedClients()
    {
        return $this->where('is_active', 0)->get()->count();
    }

    public function getCountOfClientsInLatestMonth()
    {
        $clientCount = $this->where('created_at', '>=', Carbon::now()->subMonth())->count();

        $clientsInLatestMonth = ($this->getCountClients() / 100) * $clientCount;

        return $clientsInLatestMonth . '%' ? : '0.00%';
    }

    public function getClients()
    {
        return $this->all();
    }

    public function getClientsDetails($clientId)
    {
        return $this->where('id', $clientId)->get()->last();
    }

    public function deleteClient($clientId)
    {
        $clientsModel = self::find($clientId);

        if (is_null($clientsModel)) {
            return false;
        }

        $clientsModel->delete();

        return true;
    }
}