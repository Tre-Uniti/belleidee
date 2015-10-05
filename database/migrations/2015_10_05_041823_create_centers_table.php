<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centers', function (Blueprint $table)
        {
        $table->increments('center_id');
        $table->string('name');
        $table->string('type');
        $table->string('website')->nullable();
        $table->integer('phone')->unsigned();
        $table->string('center_email')->unique();
        $table->string('center_top1');
        $table->string('center_top2');
        $table->string('center_top3');
        $table->integer('center_v3c')->unsigned();
        $table->integer('tier')->unsigned();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('centers');
    }
}
