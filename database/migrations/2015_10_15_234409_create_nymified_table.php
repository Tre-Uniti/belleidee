<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNymifiedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nymified', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('n_post_id')->unsigned()->nullable();
            $table->integer('n_extension_id')->unsigned()->nullable();
            $table->integer('n_question_id')->unsigned()->nullable();
            $table->timestamps();
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
        Schema::drop('nymified');
    }
}
