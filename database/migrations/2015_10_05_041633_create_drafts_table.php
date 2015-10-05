<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drafts', function (Blueprint $table)
        {
            $table->increments('draft_id');
            $table->string('title');
            $table->string('index')->nullable();
            $table->string('2index')->nullable();
            $table->string('nymified')->nullable();
            $table->string('draft_path');
            $table->string('source_path');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('drafts');
    }
}
