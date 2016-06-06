<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposedGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposed_goals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proposed_score_id')->unsigned()->nullable();
            $table->integer('player_id')->unsigned()->nullable();
            $table->boolean('penalty')->default(false);
            $table->boolean('own_goal')->default(false);
            $table->boolean('penalty_round')->default(false);
            $table->timestamps();

            $table->foreign('proposed_score_id')->references('id')->on('proposed_scores');
            $table->foreign('player_id')->references('id')->on('players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('proposed_goals');
    }
}
