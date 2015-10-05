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
            $table->integer('master_version')->unsigned();
            $table->string('nymified')->nullable();
            $table->string('index')->nullable();
            $table->string('index2')->nullable();
            $table->string('postPath');
            $table->string('sourcePath');
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
        Schema::drop('posts');
    }
}
