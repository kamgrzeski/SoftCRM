<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MailingModel extends Model
{
    protected $table = 'mailing';

    public function insertRow($allInputs)
    {
        return self::insertGetId(
            [
                'name' => $allInputs['name'],
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
                'updated_at' => Carbon::now(),
                'is_active' => 1
            ]);
    }

    public function setActive($id, $activeType)
    {
        $findMailingById = self::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findMailingById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function countMailing()
    {
        return self::all()->count();
    }

    public static function addEmailToMailManager($allInputs)
    {
        die('coming soon');
    }
}
