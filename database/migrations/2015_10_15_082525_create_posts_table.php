<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table)
        {
            $table->increments('post_id');
            $table->string('title');
            $table->integer('elevation')->unsigned();
            $table->integer('extension')->unsigned();
            $table->string('master_version_path')->nullable();
            $table->string('nymified')->nullable();
            $table->string('index')->nullable();
            $table->string('belief_beacon')->nullable();
            $table->string('index2')->nullable();
            $table->string('postPath');
            $table->string('sourcePath');
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
        Schema::drop('posts');
    }
}
