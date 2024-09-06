<?php

namespace App\Queries;

use App\Models\ClientsModel;

class ClientsQueries
{
    public static function getAll()
    {
        return ClientsModel::all();
    }
}
