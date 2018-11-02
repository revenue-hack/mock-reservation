<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateUserTypeRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('user_type_relations');
        Schema::create('user_type_relations', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('type_id');
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
        //
    }
}
