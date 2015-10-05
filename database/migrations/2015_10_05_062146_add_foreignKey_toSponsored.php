<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToSponsored extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sponsored', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('sponsor_id')->unsigned();
            $table->foreign('sponsor_id')->references('sponsor_id')->on('sponsors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sponsored', function (Blueprint $table) {
            $table->dropForeign('sponsored_user_id_foreign');
            $table->dropForeign('sponsored_post_id_foreign');
            $table->dropColumn('user_id');
            $table->dropColumn('sponsor_id');
        });
    }
}
