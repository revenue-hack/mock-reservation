<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('users')->truncate();
        // 初期値
        \DB::table('users')->insert([
            'name' => '中村先生',
            'role_id' => 1,
            'email' => 'hoge@gmail.com',
            'password' => bcrypt('aaaaa'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table('users')->insert([
            'name' => 'テスト',
            'role_id' => 1,
            'email' => 'test@gmail.com',
            'password' => bcrypt('aaaaa'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table('users')->insert([
            'name' => 'テスト生徒',
            'role_id' => 2,
            'email' => 'test_student@gmail.com',
            'password' => bcrypt('aaaaa'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // user_type_relations
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('user_type_relations')->truncate();
        \DB::table('user_type_relations')->insert([
            'user_id' => 1,
            'type_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table('user_type_relations')->insert([
            'user_id' => 2,
            'type_id' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
