<?php

namespace App\Queries;

use App\Models\SettingsModel;

/**
 * Class SettingsQueries
 *
 * Query class for handling operations related to the SettingsModel.
 */
class SettingsQueries
{
    /**
     * Get all settings.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return SettingsModel::all();
    }
}
