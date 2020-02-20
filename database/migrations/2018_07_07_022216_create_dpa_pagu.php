<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDpaPagu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dpa_pagu', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('pagu_value')->unsigned();
            $table->integer('fiscal_years_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('dpa_pagu', function (Blueprint $table){
           $table->foreign('fiscal_years_id')->references('id')->on('fiscal_years');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dpa_pagu');
    }
}
