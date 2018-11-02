<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTypeRelationTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_type_relations', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            //$table->foreign('user_id')->references('id')->on('roles');
            $table->integer('type_id')->unsigned();
            //$table->foreign('type_id')->references('id')->on('user_types');
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['user_id', 'type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_type_relations');
    }
}
