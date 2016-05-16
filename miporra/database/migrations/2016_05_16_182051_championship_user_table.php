<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChampionshipUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('championship_user', function (Blueprint $table) {
            $table->integer('championship_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->primary(['championship_id', 'user_id']);

            $table->foreign('championship_id')->references('id')->on('championships');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('championship_user');
    }
}
