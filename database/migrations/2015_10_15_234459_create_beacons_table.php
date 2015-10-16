<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeaconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beacons', function (Blueprint $table)
        {
            $table->increments('beacon_id');
            $table->string('name');
            $table->string('beliefcenter');
            $table->string('website')->nullable();
            $table->integer('phone')->unsigned();
            $table->string('beacon_email')->unique();
            $table->string('beacon_top1');
            $table->string('beacon_top2');
            $table->string('beacon_top3');
            $table->integer('beacon_use')->unsigned();
            $table->integer('tier')->unsigned();
            $table->string('status');
            $table->integer('user_id')->unsigned();
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
        Schema::drop('beacons');
    }
}
