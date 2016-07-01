<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameLegacyToLegacies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('legacy_posts', function (Blueprint $table) {
            $table->dropForeign('legacy_posts_legacy_id_foreign');
        });

        Schema::rename('legacy', 'legacies');

        Schema::table('legacy_posts', function (Blueprint $table) {
            $table->foreign('legacy_id')->references('id')->on('legacies');
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
            $table->dropForeign('legacy_posts_legacy_id_foreign');
        });

        Schema::rename('legacies', 'legacy');

        Schema::table('legacy_posts', function (Blueprint $table) {
            $table->foreign('legacy_id')->references('id')->on('legacy');
        });


    }
}
