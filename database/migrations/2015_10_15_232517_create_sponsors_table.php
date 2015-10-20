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
            $table->increments('sponsor_id');
            $table->string('sponsor_name');
            $table->string('sponsor_website');
            $table->string('sponsor_phone');
            $table->string('sponsor_path1');
            $table->string('sponsor_path2')->nullable();
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
