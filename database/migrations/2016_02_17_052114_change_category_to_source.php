<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCategoryToSource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        * Rename category column to source
        */
        Schema::table('posts', function ($table) {
            $table->renameColumn('category', 'source');
        });

        /*
        * Rename category column to source
        */
        Schema::table('extensions', function ($table) {
            $table->renameColumn('category', 'source');
        });

        /*
        * Rename category column to source
        */
        Schema::table('drafts', function ($table) {
            $table->renameColumn('category', 'source');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
* Rename category column to source
*/

        Schema::table('posts', function ($table) {
            $table->renameColumn('source', 'category');
        });

        /*
        * Rename category column to source
        */
        Schema::table('extensions', function ($table) {
            $table->renameColumn('source', 'category');
        });

        /*
        * Rename category column to source
        */
        Schema::table('drafts', function ($table) {
            $table->renameColumn('source', 'category');
        });
    }
}
