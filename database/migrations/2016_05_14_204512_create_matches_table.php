<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('local_score')->nullable();
            $table->integer('away_score')->nullable();
            $table->integer('championship_id')->unsigned()->nullable();
            $table->integer('local_team_id')->unsigned()->nullable();
            $table->integer('away_team_id')->unsigned()->nullable();
            $table->integer('round_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('championship_id')->references('id')->on('championships');
            $table->foreign('local_team_id')->references('id')->on('teams');
            $table->foreign('away_team_id')->references('id')->on('teams');
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
        Schema::drop('matches');
    }
}
