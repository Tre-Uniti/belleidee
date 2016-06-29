<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLegaciesWithRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('legacies', function (Blueprint $table) {
            $table->dropColumn('photo_path');
            $table->dropColumn('token');
            $table->dropColumn('name');
            $table->integer('belief_id')->unsigned();
            $table->foreign('belief_id')->references('id')->on('beliefs');
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
        Schema::table('legacies', function (Blueprint $table) {
            $table->string('photo_path');
            $table->string('token');
            $table->string('name');
            $table->dropForeign('legacies_belief_id_foreign');
            $table->dropColumn('belief_id');
            $table->dropForeign('legacies_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
}
