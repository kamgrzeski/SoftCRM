<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProjectsModel extends Model
{
    protected $table = 'projects';

    public function insertRow($allInputs)
    {
        return self::insertGetId(
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

    public function updateRow($id, $allInputs)
    {
        return self::where('id', '=', $id)->update(
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

    public function setActive($id, $activeType)
    {
        $findProjectsById = self::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findProjectsById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function countProjects()
    {
        return self::all()->count();
    }

    public static function trySearchProjectsByValue($type, $value, $paginationLimit = 10)
    {
        return self::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    public function client()
    {
        return $this->belongsTo(ClientsModel::class);
    }

    public function companies()
    {
        return $this->belongsTo(CompaniesModel::class);
    }

    public function deals()
    {
        return $this->belongsTo(DealsModel::class);
    }
}
