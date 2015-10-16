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
            $table->string('motto', 30)->nullable();
            $table->string('nymi_id', 60)->nullable();
            $table->string('photoPath1');
            $table->string('photoPath2')->nullable();
            $table->integer('user_elevation')->unsigned();
            $table->integer('user_extension')->unsigned();
            $table->integer('ninja_handle')->unsigned();
            $table->string('type');
            $table->string('ip')->nullable();
            $table->string('profile_preference')->nullable();
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
