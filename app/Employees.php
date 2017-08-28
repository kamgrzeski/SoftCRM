<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return Employees::insert(
            [
                'full_name' => $allInputs['full_name'],
                'phone' => $allInputs['phone'],
                'email' => $allInputs['email'],
                'job' => $allInputs['job'],
                'note' => $allInputs['note'],
                'client_id' => $allInputs['client_id'],
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
        return Employees::where('id', '=', $id)->update(
            [
                'full_name' => $allInputs['full_name'],
                'phone' => $allInputs['phone'],
                'email' => $allInputs['email'],
                'job' => $allInputs['job'],
                'note' => $allInputs['note'],
                'client_id' => $allInputs['client_id'],
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
                    'full_name' => 'required',
                    'phone' => 'required',
                    'email' => 'required',
                    'job' => 'required',
                    'note' => 'required',
                    'client_id' => 'required'
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
        $query = Employees::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return int
     */
    public static function countEmployees()
    {
        return count(Employees::get());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany(Companies::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deals()
    {
        return $this->belongsTo(Deals::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contacts()
    {
        return $this->belongsTo(Contacts::class);
    }
}

