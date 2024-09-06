<?php

namespace App\Queries;

use App\Models\CompaniesModel;

class CompaniesQueries
{
    public static function getAll()
    {
        return CompaniesModel::all();
    }
}
