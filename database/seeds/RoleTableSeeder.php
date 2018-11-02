<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('roles')->truncate();
        // 初期値
        \DB::table('roles')->insert([
            'role_name' => 'admin(全てできる権限)',
            'privilege_type' => 3,
            'user_flag' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table('roles')->insert([
            'role_name' => '一般ユーザ(生徒)',
            'privilege_type' => 3,
            'user_flag' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table('roles')->insert([
            'role_name' => '作成+編集+閲覧(削除はできない)',
            'privilege_type' => 2,
            'user_flag' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table('roles')->insert([
            'role_name' => '閲覧のみ',
            'privilege_type' => 1,
            'user_flag' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
