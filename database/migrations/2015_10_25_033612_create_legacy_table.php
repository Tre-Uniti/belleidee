<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegacyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legacy', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('elevation')->unsigned();
            $table->integer('extension')->unsigned();
            $table->string('motto');
            $table->string('photo_path1');
            $table->string('photo_path2')->nullable();
            $table->string('email');
            $table->string('token');
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
        Schema::drop('legacy');
    }
}
