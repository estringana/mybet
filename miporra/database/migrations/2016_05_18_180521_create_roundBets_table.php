<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundBetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roundBets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('round_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->timestamps();

            $table->foreign('round_id')->references('id')->on('rounds');
            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roundBets');
    }
}
