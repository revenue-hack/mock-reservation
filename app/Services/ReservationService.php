<?php
namespace App\Services;

use App\Repositories\ReservationFrameRepository;
use App\Repositories\ReservationRepository;
use Illuminate\Support\Collection;

class ReservationService
{

    private $periodTimes = [30, 60, 90];
    const LoginFrameColor = "#00ffff";
    const DefaultFrameColor = "#0073b7";
    const LastFrameColor = "#ff0000";
    public function __construct(ReservationFrameRepository $rfRepo, ReservationRepository $rRepo)
    {
        $this->rfRepo = $rfRepo;
        $this->rRepo = $rRepo;
    }

    public function deleteReservation($request)
    {
        // login userですでに予約されているかチェック
        $reserve = $this->rRepo->getList(['user' => true, 'start_date' => sprintf("%s %s", $request->date, $request->s_time)])->first();
        if (!is_object($reserve)) {
            return false;
        }
        if (!$this->rRepo->destroy($reserve->id) === 1) {
            return false;
        }
        return true;
    }

    public function updateReserveFrame($request)
    {
        return $this->rfRepo->update($request);
    }

    public function saveReservation($request)
    {
        $frameTimes = array();
        // requestの時間を30分単位で切り分ける
        foreach ($this->periodTimes as $time) {
            if ($request->period >= $time) {
                $plus = (int) $time - 30;
                array_push($frameTimes, sprintf("%s %s", $request->date, date("H:i:s", strtotime($request->s_time. "+". $plus. " minute"))));
            }

        }
        // 予約できる最大枠数取得
        $maxFrames = $this->rfRepo->getFrameTimeByTime($frameTimes);
        if ($maxFrames->isEmpty()) {
            \Fetch::reportLog("max reserve count not found", [$frameTimes], "critical");
            return false;
        }
        // すでに予約されている枠数取得
        $dateTimeFrames = $this->rRepo->getReserveCount($frameTimes);
        if (!$dateTimeFrames) {
            \Fetch::reportLog("login user reserved", [$frameTimes], "critical");
            return false;
        }
        if (!empty($dateTimeFrames)) {
            foreach ($dateTimeFrames as $datetime => $count) {
                // 最大予約枠数よりも多かった場合
                if (isset($maxFrames[$datetime]) && $maxFrames[$datetime] <= $count) {
                    return false;
                }
            }
        }
        return $this->rRepo->saveManyReservation($frameTimes);
    }

    public function getReserveFrames()
    {
        $now = date("Y-m-d H:i:s");
        // 現在から登録されている予約枠数取得
        $frames = $this->rfRepo->getList(['from_date' => $now]);
        $users = $this->rRepo->getList(['from_date' => $now]);
        //dd($users->where('start_date', "2017-04-04 16:00:00"));
        $frames->transform(function ($item, $key) use ($users) {
            // 指定された時間に予約を取っているユーザ名取得
            $description = "";
            $users->each(function ($values, $key) use ($item, &$description) {
                if ($item->datetime === $values->start_date) {
                    $description .= sprintf("<span style='color:%s;'>%sさん</span><br>", self::DefaultFrameColor, $values->name);
                }
            });
            $data = collect([
                'id' => $item->id,
                'reserves' => $item->frames,
                'title' => "席数". $item->frames. "席",
                'start' => $item->datetime,
                'end' => date("Y-m-d H:i:s", strtotime("+". $item->period. " minute", strtotime($item->datetime))),
                'allDay' => false,
                'description' => sprintf("この時間授業に受ける生徒<br>%s", empty($description) ? "いません" : $description),
                'backgroundColor' => self::DefaultFrameColor,
                'borderColor' => self::DefaultFrameColor,
            ]);
            return $data;
        });
        return $frames;
    }

    public function getRemainReserveFrames()
    {
        $now = date("Y-m-d H:i:s");
        // 現在から登録されている予約枠数取得
        $frames = $this->rfRepo->getList(['from_date' => $now]);
        // 現在からすでに予約されている枠数取得
        $reserves = $this->rRepo->getReservesByDate($now);
        // login userが保持している予約枠取得
        $userReserves = $this->rRepo->getList(['user' => true]);
        // 日付ごとの残り予約枠数を計算
        $frames->transform(function ($item, $key) use ($reserves, $userReserves) {
            if (!$reserves->where('start_date', $item->datetime)->isEmpty()) {
                $item->frames -= $reserves->where('start_date', $item->datetime)->first()->reserves;
            }
            $data = collect([
                'id' => $item->id,
                'reserves' => $item->frames,
                'title' => "残り席数". $item->frames. "席",
                'start' => $item->datetime,
                'end' => date("Y-m-d H:i:s", strtotime("+". $item->period. " minute", strtotime($item->datetime))),
                'allDay' => false,
                'userFlag' => false,
                'backgroundColor' => self::DefaultFrameColor,
                'borderColor' => self::DefaultFrameColor,
            ]);
            // login userがすでにとっている予約枠はbackgroundColorとuser_flagを変える
            if (!$userReserves->where('start_date', $data['start'])->isEmpty()) {
                $data['backgroundColor'] = self::LoginFrameColor;
                $data['userFlag'] = true;
            }
            // 残り一枠の場合redにする
            if ((int) $data['reserves'] === 1) {
                $data['backgroundColor'] = self::LastFrameColor;
            }
            return $data;
        });
        return $frames;
    }

    public function getReservesByUser()
    {
        $reserves = $this->rRepo->getList(['user' => true]);
        $reserves->transform(function ($item, $key) {
            $data = collect([
                'id' => $item->id,
                'title' => "授業予約",
                'start' => $item->start_date,
                'end' => date("Y-m-d H:i:s", strtotime("+". $item->period. " minute", strtotime($item->start_date))),
                'allDay' => false,
                'backgroundColor' => self::LoginFrameColor,
                'borderColor' => self::DefaultFrameColor,
            ]);
            return $data;
        });
        return $reserves;
    }
}
