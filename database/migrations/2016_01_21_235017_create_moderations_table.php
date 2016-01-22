<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModerationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moderations', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('mod_ruling');
            $table->string('admin_ruling')->nullable();
            $table->integer('mod_id')->unsigned();
            $table->integer('admin_id')->unsigned()->nullable();
            $table->integer('intolerance_id')->unsigned();
            $table->foreign('intolerance_id')->references('id')->on('intolerances');
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
        Schema::drop('moderations');
    }

}
