<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class AdminModel extends Authenticatable
{
    protected $table = 'admins';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAdminDetails(int $adminId)
    {
        return $this->find($adminId);
    }

    public function updateAdminPassword(string $newPassword, int $adminId) : int
    {
        return $this->where('id', $adminId)->update(
        [
            'password' => Hash::make($newPassword),
            'updated_at' => now()
        ]);
    }

    public function getUserInformation()
    {
        return unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$this->ip"));
    }
}
