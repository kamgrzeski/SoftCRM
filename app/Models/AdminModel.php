<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @property boolean prof_is_active
 * @property string prof_name
 * @property string prof_email
 * @property string password
 * @property string role_id
 * @property integer prof_id
 */
class AdminModel extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'admins';
    protected $fillable = ['id', 'name', 'email', 'password'];

    public function getAdminDetails(int $adminId)
    {
        return $this->find($adminId);
    }
}
