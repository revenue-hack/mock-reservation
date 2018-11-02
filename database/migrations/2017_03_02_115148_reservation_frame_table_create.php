<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReservationFrameTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_frames', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role_name', 40);
            $table->integer('year');
            $table->tinyInteger('month')->comment('予約月,0はdefault');
            $table->index('month');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reservation_frames');
    }
}
