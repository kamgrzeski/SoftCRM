<?php

namespace App\Models;

use App\Relations\Has\HasManyCompanies;
use App\Relations\Has\HasManyEmployees;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientsModel extends Model
{
    use SoftDeletes, HasManyEmployees, HasManyCompanies;

    protected $table = 'clients';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'full_name', 'phone', 'email', 'section', 'budget', 'location', 'zip', 'city', 'country', 'is_active', 'admin_id'
    ];
}
