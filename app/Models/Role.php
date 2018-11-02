<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $fillable = ['role_name', 'privilege_type', 'user_flag'];

    protected $dates = ['deleted_at'];

    public function scopeSearch($query, string $q)
    {
        return $query->where('roles.role_name', 'like', "%". $q. "%");
    }

    public function scopeId($query, int $roleId)
    {
        return $query->where('roles.id', '=', $roleId);
    }
}
