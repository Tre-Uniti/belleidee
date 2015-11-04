<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drafts', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('title');
            $table->string('index')->nullable();
            $table->string('belief_beacon')->nullable();
            $table->string('index2')->nullable();
            $table->string('nymified')->nullable();
            $table->string('draft_path');
            $table->string('source_path');
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
        Schema::drop('drafts');
    }
}
