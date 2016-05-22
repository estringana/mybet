<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBetConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bet_configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bet_mapping_class');
            $table->integer('order');
            $table->integer('number_of_bets');
            $table->integer('points_per_guess');
            $table->integer('round_id')->unsigned()->nullable();
            $table->integer('championship_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('championship_id')->references('id')->on('championships');
            $table->foreign('round_id')->references('id')->on('rounds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bet_configurations');
    }
}
