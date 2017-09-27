<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    /**
     * @param $rulesType
     * @return array
     */
    public static function getRules($rulesType)
    {
        switch ($rulesType) {
            case 'SETTINGS':
                return [
                    'pagination_size' => 'required|integer',
                    'currency' => 'required|string',
                    'priority_size' => 'required|integer',
                    'invoice_tax' => 'required|integer',
                    'invoice_logo_link' => 'required',
                ];
        }
    }
}
