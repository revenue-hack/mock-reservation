<?php
namespace App\Repositories;

use App\Models\ReservationFrame;
use Illuminate\Database\Eloquent\Collection;

class ReservationFrameRepository extends AppRepository
{

    protected function getQuery(array $where, int $id = null)
    {
        $query = ReservationFrame::select('reservation_frames.*');
        if (!is_null($id)) {
            $query->primarykey($id);
        }
        if (!empty($where['from_date'])) {
            $query->fromdate($where['from_date']);
        }
        return $query;
    }

    public function getFrameTimeByTime(array $reserveTimes)
    {
        $query = ReservationFrame::reservetime($reserveTimes)
            ->select('datetime', 'frames')
            ->get();
        $frames = collect();
        $query->each(function ($item, $key) use ($frames) {
            $frames->prepend($item->frames, $item->datetime);
        });
        return $frames;
    }

    protected function trunsactionUpdate($request)
    {
        // 予約枠がidとdateで一致するか確認(一致しなかったらreturn)
        $reserve = ReservationFrame::primarykey($request->id)
            ->datetime($request->date. " ". $request->s_time);
        if (!is_object($reserve)) {
            return false;
        }
        return ReservationFrame::where('id', $request->id)
            ->update([
                'frames' => $request->frames,
            ]);
    }
}
