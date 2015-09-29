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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('handle');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('motto', 30)->nullable();
            $table->string('nymi', 60)->nullable();
            $table->string('sponsorid, 60');
            $table->string('photoPath, 60');
            //$table->integer('v3c', 18);
            //$table->integer('ninja', 18)->nullable();
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
