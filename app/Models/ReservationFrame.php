<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationFrame extends Model
{
    use SoftDeletes;
    protected $fillable = ['frame', 'datetime', 'period'];

    protected $dates = ['deleted_at'];

    public function scopePrimaryKey($query, int $id)
    {
        return $query->where('reservation_frames.id', '=', $id);
    }

    public function scopeDateTime($query, string $datetime)
    {
        return $query->where('reservation_frames.datetime', '=', $datetime);
    }

    public function scopeReserveTime($query, array $reserveTimes)
    {
        $query->where('reservation_frames.datetime', '=', $reserveTimes[0]);
        if (isset($reserveTimes[1])) {
            $query->orWhere('reservation_frames.datetime', '=', $reserveTimes[1]);
        }
        if (isset($reserveTimes[2])) {
            $query->orWhere('reservation_frames.datetime', '=', $reserveTimes[2]);
        }
        return $query;
    }

    public function scopeFromDate($query, string $fromDate)
    {
        return $query->where('reservation_frames.datetime', '>=', $fromDate);
    }
}
