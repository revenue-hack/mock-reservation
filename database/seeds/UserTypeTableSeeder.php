<?php

use Illuminate\Database\Seeder;

class UserTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('user_types')->truncate();
        // 初期値
        \DB::table('user_types')->insert([
            'type_name' => '管理者',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table('user_types')->insert([
            'type_name' => 'そろばん生徒',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table('user_types')->insert([
            'type_name' => 'PC生徒',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
