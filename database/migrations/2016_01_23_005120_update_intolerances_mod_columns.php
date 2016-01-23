<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIntolerancesModColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Update length of user, mod, admin ruling to 300 drop unnecessary columns
        Schema::table('intolerances', function (Blueprint $table) {
            $table->string('user_ruling', 300)->change();
            $table->dropColumn('severity');
            $table->dropColumn('status');
            $table->dropColumn('sponsor_path');
            $table->dropColumn('photo_path');

        });
        Schema::table('moderations', function (Blueprint $table) {
            $table->string('mod_ruling', 300)->change();
            $table->string('admin_ruling', 300)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Update length of user, mod, admin ruling to 255 add necessary columns
        Schema::table('intolerances', function (Blueprint $table) {
            $table->string('user_ruling', 255)->change();
            $table->string('severity');
            $table->string('status');
            $table->string('sponsor_path')->nullable();
            $table->string('photo_path')->nullable();
        });

        Schema::table('moderations', function (Blueprint $table) {
            $table->string('mod_ruling', 255)->change();
            $table->string('admin_ruling', 255)->change();
        });
    }

}
