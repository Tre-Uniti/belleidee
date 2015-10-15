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
            $table->increments('extension_id');
            $table->string('title');
            $table->integer('elevation')->unsigned();
            $table->integer('extension')->unsigned();
            $table->string('ext_index')->nullable();
            $table->string('ext_belief_beacon')->nullable();
            $table->string('ext_index2')->nullable();
            $table->integer('extension_version_path')->unsigned();
            $table->string('nymified')->nullable();
            $table->string('extension_path');
            $table->string('extSource_path');
            $table->integer('post_id')->unsigned()->nullable();
            $table->integer('extenception_id')->unsigned()->nullable();
            $table->integer('question_id')->unsigned()->nullable();
            $table->timestamps();
            $table->integer('user_id')->unsigned()->nullable();
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
