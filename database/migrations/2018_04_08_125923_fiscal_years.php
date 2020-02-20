<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FiscalYears extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiscal_years', function (Blueprint $table) {
            $table->increments('id');
            $table->year('years');
            $table->integer('status')->unsigned();
        });

        Schema::table('fiscal_years', function (Blueprint $table){
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
        Schema::dropIfExists('fiscal_years');
    }
}
