<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extensions', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('title');
            $table->integer('elevation')->unsigned();
            $table->integer('extension')->unsigned();
            $table->string('index')->nullable();
            $table->string('belief_beacon')->nullable();
            $table->string('index2')->nullable();
            $table->string('nymified')->nullable();
            $table->string('extension_path');
            $table->string('source_path');
            $table->integer('post_id')->unsigned()->nullable();
            $table->integer('extencption')->unsigned()->nullable();
            $table->integer('question_id')->unsigned()->nullable();
            $table->integer('legacy_post_id')->unsigned()->nullable();
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
        Schema::drop('extensions');
    }
}
