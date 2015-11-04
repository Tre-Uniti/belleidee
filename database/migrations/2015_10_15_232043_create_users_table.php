<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('handle')->unique();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->integer('email_preference')->unsigned()->default(2);
            $table->integer('elevation')->unsigned();
            $table->integer('extension')->unsigned();
            $table->string('motto')->nullable();
            $table->string('nymi_id')->nullable();
            $table->string('photo_path1');
            $table->string('photo_path2')->nullable();
            $table->string('temp_photo_path1');
            $table->string('temp_photo_path2')->nullable();
            $table->string('type');
            $table->boolean('verified')->default(false);
            $table->string('emailToken')->nullalble();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
