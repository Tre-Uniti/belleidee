<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBeliefToLegacyPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('legacy_posts', function (Blueprint $table) {
            $table->dropColumn('excerpt');
            $table->dropColumn('post_path');
            $table->string('belief');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('legacy_posts', function (Blueprint $table) {
            $table->text('excerpt');
            $table->string('post_path');
            $table->dropColumn('belief');
        });
    }
}
