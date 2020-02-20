<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeOfGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('typeOfGoods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('typeOfGoods');
            $table->tinyInteger('formula')->unsigned();
        });

        Schema::table('typeOfGoods', function (Blueprint $table){
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
        Schema::dropIfExists('typeOfGoods');
    }
}
