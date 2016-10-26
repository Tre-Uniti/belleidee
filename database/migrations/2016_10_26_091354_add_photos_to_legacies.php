<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhotosToLegacies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('legacy_posts', function (Blueprint $table) {
            $table->string('caption')->nullable();
            $table->string('original_source_path')->nullable();
            $table->string('excerpt')->nullable()->change();
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
            $table->dropColumn('caption');
            $table->dropColumn('original_source_path');
            $table->string('excerpt')->nullable(false)->change();
        });
    }
}
