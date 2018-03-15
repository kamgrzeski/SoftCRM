<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProjectsModel extends Model
{
    /**
     * table name
     */
    protected $table = 'projects';
    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return ProjectsModel::insertGetId(
            [
                'name' => $allInputs['name'],
                'client_id' => $allInputs['client_id'],
                'companies_id' => $allInputs['companies_id'],
                'deals_id' => $allInputs['deals_id'],
                'start_date' => $allInputs['start_date'],
                'cost' => $allInputs['cost'],
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
        return ProjectsModel::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'client_id' => $allInputs['client_id'],
                'companies_id' => $allInputs['companies_id'],
                'deals_id' => $allInputs['deals_id'],
                'start_date' => $allInputs['start_date'],
                'cost' => $allInputs['cost'],
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
                    'client_id' => 'required',
                    'companies_id' => 'required',
                    'deals_id' => 'required',
                    'start_date' => 'required',
                    'cost' => 'required'
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
        $findProjectsById = ProjectsModel::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findProjectsById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return int
     */
    public static function countProjects()
    {
        return count(ProjectsModel::get());
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function trySearchProjectsByValue($type, $value, $paginationLimit = 10)
    {
        return ProjectsModel::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(ClientsModel::class);
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
    public function deals()
    {
        return $this->belongsTo(DealsModel::class);
    }

}
