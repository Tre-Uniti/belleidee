<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeaconRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beacon_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('belief');
            $table->string('email')->unique();
            $table->string('address');
            $table->string('country');
            $table->string('location');
            $table->string('website')->nullable();
            $table->string('phone');
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
        Schema::drop('beacon_requests');
    }
}
