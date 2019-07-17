<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompaniesModel extends Model
{
    use SoftDeletes;

    protected $table = 'companies';

    public function getCountCompanies()
    {
        return $this->all()->count();
    }

    public function getCountOfDeactivatedCompanies()
    {
        return $this->where('is_active', 0)->get()->count();
    }

    public function getCountOfDeactivatedCompaniesInLatestMonth()
    {
        $companiesCount = $this->where('created_at', '>=', Carbon::now()->subMonth())->count();

        $companiesInLatestMonth = ($this->getCountCompanies() / 100) * $companiesCount;

        return $companiesInLatestMonth . '%' ? : '0.00%';
    }

    public function getCompanies()
    {
        return self::all()->slice(0, 5);
    }

    public function getCompaniesAssignedToClient($clientId)
    {
        return $this->where('client_id', $clientId)->get()->count();
    }

    public function getCompaniesDetailsAssignedToClient($clientId)
    {
        return $this->where('client_id', $clientId)->get();
    }
}