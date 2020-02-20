<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigFiscalYears extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_fiscal_years', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status');
            //$table->timestamps();
        });

        Schema::table('config_fiscal_years', function (Blueprint $table){
           $table->integer('fiscal_years_id')->unsigned();
           $table->integer('management_users_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_fiscal_years');
    }
}
