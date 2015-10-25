<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsorPromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsor_promo', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('tier1');
            $table->integer('tier2');
            $table->integer('tier3');
            $table->string('promo1');
            $table->string('promo2');
            $table->string('promo3');
            $table->timestamps();
            $table->integer('sponsor_id')->unsigned();
            $table->foreign('sponsor_id')->references('id')->on('sponsors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sponsor_promo');
    }
}
