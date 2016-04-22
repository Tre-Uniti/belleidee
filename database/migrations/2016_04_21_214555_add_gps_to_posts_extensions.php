<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGpsToPostsExtensions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->double('lat', 10, 6)->nullable();
            $table->double('long', 10, 6)->nullable();
        });
        Schema::table('extensions', function (Blueprint $table) {
            $table->double('lat', 10, 6)->nullable();
            $table->double('long', 10, 6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('long');
        });
        Schema::table('extensions', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('long');
        });
    }
}
