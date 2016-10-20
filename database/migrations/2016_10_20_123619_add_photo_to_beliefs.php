<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhotoToBeliefs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beliefs', function (Blueprint $table) {
            $table->string('photo_path');
            $table->text('description')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beliefs', function (Blueprint $table) {
            $table->dropColumn('photo_path');
            $table->string('description')->change();
        });
    }
}
