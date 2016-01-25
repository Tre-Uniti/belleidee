<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjudicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjudications', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('admin_ruling')->nullable();
            $table->integer('moderation_id')->unsigned();
            $table->foreign('moderation_id')->references('id')->on('moderations');
            $table->integer('intolerance_id')->unsigned();
            $table->foreign('intolerance_id')->references('id')->on('intolerances');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::table('moderations', function (Blueprint $table) {
            $table->dropColumn('admin_ruling');
            $table->dropColumn('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('adjudications');

        Schema::table('moderations', function (Blueprint $table) {
            $table->string('admin_ruling')->nullable();
            $table->integer('admin_id')->unsigned()->nullable();
        });
    }
}
