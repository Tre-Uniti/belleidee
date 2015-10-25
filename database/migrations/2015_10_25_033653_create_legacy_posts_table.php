<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegacyPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legacy_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->integer('elevation')->unsigned();
            $table->integer('extension')->unsigned();
            $table->string('post_path')->nullable();
            $table->string('source_path')->nullable();
            $table->timestamps();
            $table->integer('legacy_id')->unsigned();
            $table->foreign('legacy_id')->references('id')->on('legacy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('legacy_posts');
    }
}
