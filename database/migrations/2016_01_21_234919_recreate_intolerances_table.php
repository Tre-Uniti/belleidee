<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateIntolerancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('intolerant');

        Schema::create('intolerances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('severity')->unsigned();
            $table->string('status');
            $table->string('user_ruling');
            $table->string('sponsor_path')->nullable();
            $table->string('photo_path')->nullable();
            $table->integer('extension_id')->unsigned()->nullable();
            $table->integer('question_id')->unsigned()->nullable();
            $table->integer('legacy_post_id')->unsigned()->nullable();
            $table->integer('post_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::create('intolerant', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('descentLevel')->unsigned();
            $table->string('sponsor_path')->nullable();
            $table->string('sponsor_path2')->nullable();
            $table->string('photo_path1')->nullable();
            $table->string('photo_path2')->nullable();
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts');
        });

        Schema::drop('intolerances');
    }

}
