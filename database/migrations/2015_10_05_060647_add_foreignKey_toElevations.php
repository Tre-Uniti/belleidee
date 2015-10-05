<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToElevations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('elevations', function (Blueprint $table) {
            $table->integer('post_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('post_id')->references('post_id')->on('posts');
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
        Schema::table('elevations', function (Blueprint $table) {
            $table->dropForeign('elevations_post_id_foreign');
            $table->dropForeign('elevations_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropColumn('post_id');
        });
    }
}
