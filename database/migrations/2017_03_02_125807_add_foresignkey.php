<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForesignkey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->foreign('role_id')
                ->references('id')
                ->on('roles');
        });
        Schema::table('reservations', function ($table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
        Schema::table('user_type_relations', function ($table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('roles');
            $table->foreign('type_id')
                ->references('id')
                ->on('user_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
