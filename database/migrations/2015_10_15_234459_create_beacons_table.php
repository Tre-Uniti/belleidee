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
            $table->increments('id');
            $table->string('name');
            $table->string('beacon_tag')->unique();
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
            $table->string('country_code');
            $table->string('location_code');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
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
