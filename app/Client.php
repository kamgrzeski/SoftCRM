<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return Client::insert(
            [
                'full_name' => $allInputs['full_name'],
                'phone' => $allInputs['phone'],
                'email' => $allInputs['email'],
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
        return Client::where('id', '=', $id)->update(
            [
                'full_name' => $allInputs['full_name'],
                'phone' => $allInputs['phone'],
                'email' => $allInputs['email'],
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
                    'full_name' => 'required|string',
                    'phone' => 'required|integer',
                    'email' => 'required|email',
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
        $query = Client::where('id', '=', $id)->update(['is_active' => $activeType]);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return int
     */
    public static function countClients()
    {
        return count(Client::get());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany(Companies::class);
    }
}
