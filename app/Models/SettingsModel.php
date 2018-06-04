<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsModel extends Model
{
    protected $table = 'systemlogs';
    /**
     * @param $rulesType
     * @return array
     */
    public function getRules($rulesType)
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
