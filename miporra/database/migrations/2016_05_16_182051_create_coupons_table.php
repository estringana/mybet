<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('championship_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->unique(['championship_id', 'user_id']);

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
        Schema::drop('coupons');
    }
}
