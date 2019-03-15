<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FilesModel extends Model
{
    protected $table = 'files';

    public function insertRow($allInputs)
    {
        return self::insertGetId(
            [
                'name' => $allInputs['name'],
                'companies_id' => $allInputs['companies_id'],
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
                'companies_id' => $allInputs['companies_id'],
                'updated_at' => Carbon::now(),
                'is_active' => 1
            ]);
    }

    public function setActive($id, $activeType)
    {
        $findFilesById = self::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findFilesById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function countFiles()
    {
        return count(self::get());
    }

    public function companies()
    {
        return $this->belongsTo(CompaniesModel::class);
    }

    public function trySearchFilesByValue($type, $value, $paginationLimit = 10)
    {
        return self::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    public function getPluckCompanies()
    {
        return self::pluck('name', 'id');
    }
}
