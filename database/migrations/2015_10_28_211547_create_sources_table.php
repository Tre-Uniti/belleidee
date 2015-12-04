<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nameHandle');
            $table->string('url')->nullable();
            $table->string('isbn')->nullable();
            $table->string('loc');
            $table->integer('post_id')->unsigned()->nullable();
            $table->integer('extension_id')->unsigned()->nullable();
            $table->integer('question_id')->unsigned()->nullable();
            $table->integer('legacy_post_id')->unsigned()->nullable();
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
        Schema::drop('sources');
    }
}
