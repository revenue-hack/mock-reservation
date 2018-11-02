<?php

use Illuminate\Database\Seeder;

class ReservationFrameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('reservation_frames')->truncate();
        // 実行日から2ヶ月先まで予約枠を作成
        $j = 0;
        do {
            $i = 0;
            $date = strtotime("+". $j. " day");
            do {
                $time = strtotime("15:00:00+". 30* $i. " minute");
                \DB::table('reservation_frames')->insert([
                    'datetime' => sprintf("%s %s", date('Y-m-d', $date), date("H:i:s", $time)),
                    'period' => 30,
                    'frames' => 6,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $i++;
            } while($time < strtotime("20:00:00"));
            $j++;
        } while ($date <= strtotime(sprintf("%s", date('Y-m-d', mktime(0, 0, 0, date('m') + 3, 0, date('Y'))))));
    }
}
