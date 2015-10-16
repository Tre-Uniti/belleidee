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
            $table->increments('draft_id');
            $table->string('title');
            $table->string('draft_index')->nullable();
            $table->string('draft_belief_beacon')->nullable();
            $table->string('draft_index2')->nullable();
            $table->string('nymified')->nullable();
            $table->string('draft_path');
            $table->string('source_path');
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
