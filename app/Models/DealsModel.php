<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealsModel extends Model
{
    use SoftDeletes;

    protected $table = 'deals';

    public function getCountDeals()
    {
        return $this->all()->count();
    }

    public function getCountOfDeactivatedDeals()
    {
        return $this->where('is_active', 0)->get()->count();
    }

    public function getCountOfDealsInLatestMonth()
    {
        $dealsCount = $this->where('created_at', '>=', Carbon::now()->subMonth())->count();

        $dealsInLatestMonth = ($this->getCountDeals() / 100) * $dealsCount;

        return $dealsInLatestMonth . '%' ? : '0.00%';
    }

    public function getDeals()
    {
        return $this->all();
    }

    public function getDealDetails($dealId)
    {
        return $this->where('id', $dealId)->get()->last();
    }

    public function deleteDeal($dealId)
    {
        $dealModel = self::find($dealId);

        if (is_null($dealModel)) {
            return false;
        }

        $dealModel->delete();

        return true;
    }
}