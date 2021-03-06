<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchBetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matchBets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('match_id')->unsigned()->nullable();
            $table->enum('prediction', ['1', 'X', '2'])->nullable();
            $table->timestamps();

            $table->foreign('match_id')->references('id')->on('matches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('matchBets');
    }
}
