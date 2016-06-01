<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeliefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beliefs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('belief');
            $table->string('description');
            $table->integer('beacons')->unsigned();
            $table->integer('posts')->unsigned();
            $table->integer('extensions')->unsigned();
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
        Schema::drop('beliefs');
    }
}
