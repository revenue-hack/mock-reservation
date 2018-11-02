<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'start_date', 'period'];

    protected $dates = ['deleted_at'];

    public function scopeReserveTime($query, string $dateTime)
    {
        return $query->where('reservations.start_date', '=', $dateTime);
    }

    public function scopeFromDate($query, string $fromDate)
    {
        return $query->where('reservations.start_date', '>=', $fromDate);
    }

    public function scopeLoginUser($query)
    {
        return $query->where('reservations.user_id', '=', \Auth::user()->id);
    }

    public  function scopePrimaryKey($query, int $id)
    {
        return $query->where('reservations.id', '=', $id);
    }
}
