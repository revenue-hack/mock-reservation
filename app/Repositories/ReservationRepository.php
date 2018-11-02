<?php
namespace App\Repositories;

use App\Models\Reservation;

class ReservationRepository extends AppRepository
{
    protected function getQuery(array $where, int $id = null)
    {
        $query = Reservation::join('users', 'users.id', '=', 'reservations.user_id')
            ->select('reservations.*', 'users.name');
        if (!empty($where['user'])) {
            $query->loginuser();
        }
        if (!empty($where['start_date'])) {
            $query->reservetime($where['start_date']);
        }
        if (!empty($where['from_date'])) {
            $query->fromdate($where['from_date']);
        }
        if (!is_null($id)) {
            $query->primarykey($id);
        }
        return $query;
    }

    public function getReservesByDate(string $fromDate)
    {
        return Reservation::fromdate($fromDate)
            ->groupBy('start_date')
            ->select(\DB::raw('count(id) as reserves'), 'start_date')
            ->get();
    }

    protected function trunsactionCreate($request)
    {
        return Reservation::create([
            'user_id' => \Auth::user()->id,
            'start_date' => $request,
            'period' => 30
        ]);
    }

    protected function trunsactionDestroy(int $id)
    {
        return Reservation::destroy($id);
    }

    public function getReserveCount(array $dateTimes)
    {
        if (empty($dateTimes)) {
            return false;
        }
        $frames = array();
        foreach ($dateTimes as $dateTime) {
            // すでにlogin userが予約している場合false
            if (!$this->getList(['user' => true, 'start_date' => $dateTime])->isEmpty()) {
                return false;
            }
            // 指定された時間に予約されている枠取得
            $count = Reservation::reservetime($dateTime)
                ->groupBy('start_date')
                ->count();
            $frames = array_merge($frames, [$dateTime => $count]);
        }
        return $frames;
    }

    public function saveManyReservation(array $dateTimes)
    {
        try {
            return \DB::transaction(function () use ($dateTimes) {
                foreach ($dateTimes as $datetime) {
                    if (!$this->save($datetime)) {
                        return false;
                    }
                }
                return true;
            });
        } catch (\Exception $e) {
            \Fetch::reportLog("save many reservation trunsaction error",
                (array) $e);
            return false;
        }
    }
}
