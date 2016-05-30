<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('round_team', function (Blueprint $table) {
            $table->integer('round_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->primary(['round_id', 'team_id']);

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
        Schema::drop('round_team');
    }
}
