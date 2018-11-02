<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTypeRelation extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'type_id'];

    protected $dates = ['deleted_at'];

}
