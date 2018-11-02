<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeRoleId($query, int $roleId)
    {
        return $query->where('users.role_id', '=', $roleId);
    }

    public function scopeId($query, int $userId)
    {
        return $query->where('users.id', '=', $userId);
    }

    public function scopeSearch($query, string $q)
    {
        return $query->where('users.name', 'like', "%". $q. "%");
    }
}
