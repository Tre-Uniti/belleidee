<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsors', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('website');
            $table->string('phone');
            $table->string('path1');
            $table->string('path2')->nullable();
            $table->string('status');
            $table->integer('budget')->unsigned();
            $table->integer('views')->unsigned();
            $table->integer('triggers')->unsigned();
            $table->boolean('adult');
            $table->string('country_code');
            $table->string('location_code');
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
        Schema::drop('sponsors');
    }
}
