<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DealsModel extends Model
{
    /**
     * table name
     */
    protected $table = 'deals';

    /**
     * @param $allInputs
     * @return mixed
     */
    public function insertGetId($allInputs)
    {
        return DealsModel::insert(
            [
                'name' => $allInputs['name'],
                'start_time' => $allInputs['start_time'],
                'end_time' => $allInputs['end_time'],
                'companies_id' => $allInputs['companies_id'],
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
        return DealsModel::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'start_time' => $allInputs['start_time'],
                'end_time' => $allInputs['end_time'],
                'companies_id' => $allInputs['companies_id'],
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
                    'start_time' => 'required',
                    'end_time' => 'required',
                    'companies_id' => 'required',
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
        $findDealsById = DealsModel::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findDealsById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return int
     */
    public static function countDeals()
    {
        return count(DealsModel::get());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companies()
    {
        return $this->belongsTo(CompaniesModel::class);
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function trySearchDealsByValue($type, $value, $paginationLimit = 10)
    {
        return DealsModel::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    /**
     * @return float|int
     */
    public static function getDealsInLatestMonth() {
        $dealsCount = DealsModel::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $allDeals = DealsModel::all()->count();

        $percentage = ($allDeals / 100) * $dealsCount;

        return $percentage;
    }

    /**
     * @return mixed
     */
    public static function getDeactivated()
    {
        return DealsModel::where('is_active', '=', 0)->count();
    }
}
